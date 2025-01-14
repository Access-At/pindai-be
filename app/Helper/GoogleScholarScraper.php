<?php

namespace App\Helper;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;

class GoogleScholarScraper
{
    private static Client $client;

    private const USER_AGENTS = [
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36',
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0',
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36',
        'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36',
        'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:109.0) Gecko/20100101 Firefox/109.0',
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/109.0',
    ];

    private const GOOGLE_SCHOLAR_BASE_URL = 'https://scholar.google.com';
    private const DEFAULT_AVATAR = '/citations/images/avatar_scholar_128.png';

    public function __construct()
    {
        self::initializeClient();
    }

    private static function initializeClient(): void
    {
        self::$client = new Client([
            'headers' => [
                'User-Agent' => self::USER_AGENTS[array_rand(self::USER_AGENTS)],
            ],
            'timeout' => 10,
            'connect_timeout' => 5,
            'http_errors' => false,
            'verify' => false,
        ]);
    }

    public static function searchAuthor(string $name): array
    {
        if (!isset(self::$client)) {
            self::initializeClient();
        }

        try {
            $response = self::$client->get(self::buildSearchUrl($name));

            if ($response->getStatusCode() !== 200) {
                return [];
            }

            $crawler = new Crawler($response->getBody()->getContents());
            return $crawler->filter('.gsc_1usr')->each(
                fn(Crawler $node) => self::extractAuthorData($node)
            );
        } catch (\Exception) {
            return [];
        }
    }

    private static function buildSearchUrl(string $name): string
    {
        return self::GOOGLE_SCHOLAR_BASE_URL . '/citations?view_op=search_authors&mauthors=' . urlencode($name);
    }

    private static function extractAuthorData(Crawler $node): array
    {
        $profileUrl = $node->filter('.gs_ai_name a')->attr('href');
        parse_str(parse_url($profileUrl, PHP_URL_QUERY), $queryParams);

        return [
            'name' => $node->filter('.gs_ai_name a')->text(),
            'id' => $queryParams['user'] ?? null,
            'photo' => self::processAuthorPhoto($node->filter('.gs_ai_pho img')->attr('src')),
            'profile_url' => self::GOOGLE_SCHOLAR_BASE_URL . $profileUrl,
            'affiliation' => $node->filter('.gs_ai_aff')->text(),
            'citations' => $node->filter('.gs_ai_cby')->text(),
        ];
    }

    private static function processAuthorPhoto(string $photo): string
    {
        // TODO: BENERIN

        // Jika URL mengandung 'scholar.googleusercontent.com', ubah 'small' menjadi 'medium'
        if (str_contains($photo, 'scholar.googleusercontent.com')) {
            return str_replace('small', 'medium', $photo);
        } elseif (str_contains($photo, 'view_photo')) {
            return str_replace('view_photo', 'medium_photo', $photo);
        } else {
            // Jika tidak ada kecocokan, gunakan avatar default
            return self::GOOGLE_SCHOLAR_BASE_URL . self::DEFAULT_AVATAR;
        }
    }

    public static function getAuthorProfile(string $authorId): ?array
    {
        if (!isset(self::$client)) {
            self::initializeClient();
        }

        try {
            $response = self::$client->get(self::GOOGLE_SCHOLAR_BASE_URL . '/citations?user=' . urlencode($authorId));

            if ($response->getStatusCode() !== 200) {
                Log::warning("Failed to fetch profile for author ID: $authorId, status code: " . $response->getStatusCode());
                return null;
            }

            $crawler = new Crawler($response->getBody()->getContents());

            return [
                'name' => $crawler->filter('#gsc_prf_in')->text(),
                // 'name_other' => $crawler->filter('#gsc_prf_in')->text(),
                'profile_url' => "https://scholar.google.com/citations?user=$authorId",
                'photo' => self::processAuthorPhoto($crawler->filter('#gsc_prf_pup-img')->attr('src')),
                'affiliation' => $crawler->filter('.gsc_prf_il')->first()->text(),
                'h_index' => $crawler->filter('td.gsc_rsb_std')->eq(2)->text(),
                'i10_index' => $crawler->filter('td.gsc_rsb_std')->eq(4)->text(),
                'total_citations' => $crawler->filter('td.gsc_rsb_std')->first()->text(),
                'publications' => self::extractPublications($crawler),
            ];
        } catch (\Exception $e) {
            Log::error('Error while fetching author profile', ['author_id' => $authorId, 'message' => $e->getMessage()]);
            return null;
        }
    }

    private static function extractPublications(Crawler $crawler): array
    {
        return $crawler->filter('.gsc_a_tr')->each(function (Crawler $node) {
            return [
                'title' => $node->filter('.gsc_a_t a')->text(),
                'link' => self::GOOGLE_SCHOLAR_BASE_URL . $node->filter('.gsc_a_t a')->attr('href'),
                'authors' => $node->filter('.gsc_a_at+div')->text(),
                'journal' => $node->filter('.gs_gray')->eq(1)->text(),
                'citations' => $node->filter('.gsc_a_c a')->text(),
                'year' => $node->filter('.gsc_a_y span')->text(),
            ];
        });
    }
}
