<?php
namespace App\Commands;
 
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Service\ZaloService;

class GetTagsCommand extends Command
{
    /**
     * @var ZaloService
     */
    private $zaloService;

    public function __construct(ZaloService $zaloService)
    {
        parent::__construct();
        $this->zaloService = $zaloService;
    }

    protected function configure()
    {
        $this->setName('get-tags-of-oa')
            ->setDescription('Get tags of OA')
            ->setHelp('Demonstration of custom commands created by Symfony Console component.');
    }
 
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $result = $this->zaloService->getTags();
        var_dump($result);
        return $result ? Command::SUCCESS : Command::FAILURE;
    }
}