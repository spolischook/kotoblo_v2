<?php

namespace App\Command;

use App\Entity\Article;
use App\Entity\Tag;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Mysqli\Driver;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeFixturesFromMysql extends Command
{
    /** @var ObjectManager  */
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('app:make-fixtures')
            ->setDescription('Make fixtures form Mysql Db')
            ->addArgument('db-name', InputArgument::REQUIRED, 'Db name')
            ->addOption('username', null, InputArgument::OPTIONAL, '', 'root')
            ->addOption('password', null, InputArgument::OPTIONAL, '', '')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $connectionParams = array(
            'dbname' => $input->getArgument('db-name'),
            'user' => $input->getOption('username'),
            'password' => $input->getOption('password'),
            'host' => 'localhost',
            'driver' => 'pdo_mysql',
            'charset'  => 'utf8',
            'driverOptions' => [
                1002 => 'SET NAMES utf8'
            ]
        );
        $conn = DriverManager::getConnection($connectionParams, new Configuration());
        $tags = $this->getTags($conn);
        $articles = $this->getArticles($conn);
        $this->tagArticles($conn, $articles, $tags);

        foreach ($tags as $tag) {
            $this->objectManager->persist($tag);
        }

        foreach ($articles as $article) {
            $this->objectManager->persist($article);
        }

        $this->objectManager->flush();
        $output->writeln("<fg=green>Move data with SUCCESS!</>");
    }

    private function getArticles(Connection $conn): array
    {
        $sql = /** @lang sql */
            "SELECT * FROM articles";
        $stmt = $conn->query($sql);

        $articles = [];
        while ($row = $stmt->fetch()) {
            $article = new Article();
            $article
                ->setId($row['id'])
                ->setTitle($row['title'])
                ->setSlug($row['slug'])
                ->setText($row['text'])
                ->setTextSource($row['textSource'])
                ->setImage($row['image'])
                ->setPublished($row['publish'])
                ->setCreatedAt(new \DateTime($row['created_at']))
                ->setUpdatedAt(new \DateTime($row['created_at']))
            ;
            $articles[$row['id']] = $article;
        }

        return $articles;
    }

    private function getTags(Connection $conn): array
    {
        $sql = /** @lang sql */
            "SELECT * FROM tags";
        $stmt = $conn->query($sql);

        $tags = [];
        while ($row = $stmt->fetch()) {
            $tag = new Tag();
            $tag
                ->setId($row['id'])
                ->setTitle($row['title'])
                ->setSlug($row['slug'])
                ->setWeight($row['weight'])
            ;
            $tags[$row['id']] = $tag;
        }

        return $tags;
    }

    /**
     * @param Connection $conn
     * @param Article[] $articles
     * @param Tag[] $tags
     */
    private function tagArticles(Connection $conn, array $articles, array $tags)
    {
        $sql = /** @lang sql */
            "SELECT * FROM tag_article";
        $stmt = $conn->query($sql);

        while ($row = $stmt->fetch()) {
            $tagId = $row['tag_id'];
            $articleId = $row['article_id'];

            $articles[$articleId]->addTag($tags[$tagId]);
        }
    }
}
