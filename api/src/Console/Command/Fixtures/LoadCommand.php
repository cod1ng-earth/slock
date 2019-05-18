<?php

declare(strict_types=1);

namespace App\Console\Command\Fixtures;

use Doctrine\ORM;
use Nelmio\Alice;
use Symfony\Component\Console;
use Symfony\Component\Finder;

final class LoadCommand extends Console\Command\Command
{
    protected static $defaultName = 'slock:fixtures:load';

    private $loader;
    private $entityManager;

    public function __construct(ORM\EntityManagerInterface $entityManager)
    {
        parent::__construct();

        $this->loader = new Alice\Loader\NativeLoader();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this->setDescription('Loads fixtures');
        $this->setDefinition([
            new Console\Input\InputOption(
                'file',
                '',
                Console\Input\InputOption::VALUE_REQUIRED,
                'The path to a file containing fixtures.',
                ''
            ),
            new Console\Input\InputOption(
                'directory',
                '',
                Console\Input\InputOption::VALUE_REQUIRED,
                'The path to a file containing fixtures.',
                ''
            ),
        ]);
    }

    protected function execute(Console\Input\InputInterface $input, Console\Output\OutputInterface $output): int
    {
        $io = new Console\Style\SymfonyStyle(
            $input,
            $output
        );

        $io->title('Load Fixtures');

        /** @var string $directory */
        $directory = $input->getOption('directory');

        /** @var string $file */
        $file = $input->getOption('file');

        if ('' === $directory && '' === $file) {
            $io->error('At least one of the options "--directory" or "--file" needs to be specified.');

            return 1;
        }

        $files = [];

        if ('' !== $file) {
            if (!file_exists($file)) {
                $io->error(sprintf(
                    'File "%s" does not exist.',
                    $file
                ));

                return 1;
            }

            $files = [
                new \SplFileInfo($file),
            ];
        }

        if ('' !== $directory) {
            $finder = Finder\Finder::create()
                ->files()
                ->in($directory)
                ->name('*.yaml');

            $files = array_merge(
                $files,
                iterator_to_array($finder)
            );
        }

        if (0 === count($files)) {
            $io->error(sprintf(
                'Could not find any files in directory "%s".',
                $directory
            ));

            return 1;
        }

        $io->section('Loading fixtures');

        try {
            $fixtures = $this->loader->loadFiles($files);
        } catch (\Exception $exception) {
            $io->error(sprintf(
                'Failed loading fixtures, as an exception with message "%s" was thrown.',
                $exception->getMessage()
            ));

            return 1;
        }

        foreach ($fixtures->getObjects() as $object) {
            $this->entityManager->persist($object);
        }

        try {
            $this->entityManager->flush();
        } catch (\Exception $exception) {
            $io->error(sprintf(
                'Failed persisting fixtures, as an exception with message "%s" was thrown.',
                $exception->getMessage()
            ));

            return 1;
        }

        $kinds = array_reduce(
            $fixtures->getObjects(),
            static function (array $kinds, object $object): array {
                $className = get_class($object);

                if (!array_key_exists($className, $kinds)) {
                    $kinds[$className] = 0;
                }

                ++$kinds[$className];

                return $kinds;
            },
            []
        );

        ksort($kinds);

        $io->listing(array_map(static function (string $kind, int $count): string {
            return sprintf(
                '%s (%d)',
                $kind,
                $count
            );
        }, array_keys($kinds), array_values($kinds)));

        $io->success(sprintf(
            'Successfully loaded %d entities.',
            count($fixtures->getObjects()),
        ));

        return 0;
    }
}
