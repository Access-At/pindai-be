<?php

namespace App\Console\Commands;

use ReflectionClass;
use ReflectionMethod;
use ReflectionParameter;
use Illuminate\Console\Command;

class SyncRepositoryMethods extends Command
{
    protected $signature = 'sync:repository-methods';

    protected $description = 'Check and sync methods between Repositories and their Interfaces';

    public function handle()
    {
        $repositoryPath = app_path('Repositories');
        $interfacePath = app_path('RepositoriesInterface');

        $repositoryFiles = glob("{$repositoryPath}/*.php");
        $updated = false;

        // dd($repositoryFiles);

        foreach ($repositoryFiles as $repositoryFile) {
            $repositoryClass = $this->getClassFromFile($repositoryFile);
            $interfaceClass = $this->getInterfaceFromRepository($repositoryClass, $interfacePath);

            if ( ! $interfaceClass) {
                $this->warn("No interface found for {$repositoryClass}");

                continue;
            }

            $missingMethods = $this->getMissingMethods($repositoryClass, $interfaceClass);

            if ( ! empty($missingMethods)) {
                $this->info("Syncing methods for {$interfaceClass}...");
                $this->addMethodsToInterface($interfaceClass, $repositoryClass, $missingMethods);
                $updated = true;
            } else {
                $this->info("No missing methods for {$repositoryClass}");
            }
        }

        if ($updated) {
            $this->info('All missing methods have been added to their respective interfaces.');
        } else {
            $this->info('No updates were necessary. Everything is in sync.');
        }
    }

    private function getClassFromFile(string $filePath): string
    {
        $contents = file_get_contents($filePath);
        // dd($contents);

        preg_match('/namespace\s+(.+?);/', $contents, $namespaceMatch);
        preg_match('/class\s+(\w+)/', $contents, $classMatch);

        if (isset($namespaceMatch[1], $classMatch[1])) {
            return $namespaceMatch[1] . '\\' . $classMatch[1];
        }

        return '';
    }

    private function getInterfaceFromRepository(string $repositoryClass, string $interfacePath): ?string
    {
        $reflection = new ReflectionClass($repositoryClass);
        $interfaceName = $reflection->getShortName() . 'Interface';
        $interfaceFile = $interfacePath . '/' . $interfaceName . '.php';

        if (file_exists($interfaceFile)) {
            return $this->getClassFromFile($interfaceFile);
        }

        return null;
    }

    private function getMissingMethods(string $repositoryClass, string $interfaceClass): array
    {
        $repositoryReflection = new ReflectionClass($repositoryClass);
        $interfaceReflection = new ReflectionClass($interfaceClass);

        $repositoryMethods = array_map(fn ($method) => $method->getName(), $repositoryReflection->getMethods(ReflectionMethod::IS_PUBLIC));
        $interfaceMethods = array_map(fn ($method) => $method->getName(), $interfaceReflection->getMethods());

        return array_diff($repositoryMethods, $interfaceMethods);
    }

    private function addMethodsToInterface(string $interfaceClass, string $repositoryClass, array $methods)
    {
        $repositoryReflection = new ReflectionClass($repositoryClass);
        $reflection = new ReflectionClass($interfaceClass);
        $interfaceFile = $reflection->getFileName();

        $methodSignatures = array_map(function ($method) use ($repositoryReflection) {
            $reflectionMethod = $repositoryReflection->getMethod($method);
            $parameters = array_map(fn ($param) => $this->formatParameter($param), $reflectionMethod->getParameters());

            $parameterString = implode(', ', $parameters);

            return "    public static function {$method}({$parameterString});";
        }, $methods);

        $methodSignaturesString = implode("\n", $methodSignatures);

        $contents = file_get_contents($interfaceFile);

        $newContents = preg_replace(
            '/\}$/',
            "\n" . $methodSignaturesString . "\n}",
            $contents
        );

        file_put_contents($interfaceFile, $newContents);
    }

    private function formatParameter(ReflectionParameter $param): string
    {
        $type = $param->getType();
        $typeString = $type ? $type->getName() . ' ' : '';
        $default = $param->isOptional() && $param->isDefaultValueAvailable()
            ? ' = ' . var_export($param->getDefaultValue(), true)
            : '';

        return $typeString . '$' . $param->getName() . $default;
    }
}
