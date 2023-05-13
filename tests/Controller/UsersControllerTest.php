<?php

namespace App\Test\Controller;

use App\Entity\Users;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UsersControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private UsersRepository $repository;
    private string $path = '/users/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Users::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('User index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'user[imageSize]' => 'Testing',
            'user[updatedAt]' => 'Testing',
            'user[fname]' => 'Testing',
            'user[lname]' => 'Testing',
            'user[email]' => 'Testing',
            'user[phone]' => 'Testing',
            'user[password]' => 'Testing',
            'user[status]' => 'Testing',
            'user[description]' => 'Testing',
            'user[profile_img]' => 'Testing',
            'user[back_img]' => 'Testing',
            'user[usersBlockeds]' => 'Testing',
            'user[usersDeleteds]' => 'Testing',
        ]);

        self::assertResponseRedirects('/users/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Users();
        $fixture->setImageSize('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setFname('My Title');
        $fixture->setLname('My Title');
        $fixture->setEmail('My Title');
        $fixture->setPhone('My Title');
        $fixture->setPassword('My Title');
        $fixture->setStatus('My Title');
        $fixture->setDescription('My Title');
        $fixture->setProfile_img('My Title');
        $fixture->setBack_img('My Title');
        $fixture->setUsersBlockeds('My Title');
        $fixture->setUsersDeleteds('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('User');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Users();
        $fixture->setImageSize('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setFname('My Title');
        $fixture->setLname('My Title');
        $fixture->setEmail('My Title');
        $fixture->setPhone('My Title');
        $fixture->setPassword('My Title');
        $fixture->setStatus('My Title');
        $fixture->setDescription('My Title');
        $fixture->setProfile_img('My Title');
        $fixture->setBack_img('My Title');
        $fixture->setUsersBlockeds('My Title');
        $fixture->setUsersDeleteds('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'user[imageSize]' => 'Something New',
            'user[updatedAt]' => 'Something New',
            'user[fname]' => 'Something New',
            'user[lname]' => 'Something New',
            'user[email]' => 'Something New',
            'user[phone]' => 'Something New',
            'user[password]' => 'Something New',
            'user[status]' => 'Something New',
            'user[description]' => 'Something New',
            'user[profile_img]' => 'Something New',
            'user[back_img]' => 'Something New',
            'user[usersBlockeds]' => 'Something New',
            'user[usersDeleteds]' => 'Something New',
        ]);

        self::assertResponseRedirects('/users/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getImageSize());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getFname());
        self::assertSame('Something New', $fixture[0]->getLname());
        self::assertSame('Something New', $fixture[0]->getEmail());
        self::assertSame('Something New', $fixture[0]->getPhone());
        self::assertSame('Something New', $fixture[0]->getPassword());
        self::assertSame('Something New', $fixture[0]->getStatus());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getProfile_img());
        self::assertSame('Something New', $fixture[0]->getBack_img());
        self::assertSame('Something New', $fixture[0]->getUsersBlockeds());
        self::assertSame('Something New', $fixture[0]->getUsersDeleteds());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Users();
        $fixture->setImageSize('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setFname('My Title');
        $fixture->setLname('My Title');
        $fixture->setEmail('My Title');
        $fixture->setPhone('My Title');
        $fixture->setPassword('My Title');
        $fixture->setStatus('My Title');
        $fixture->setDescription('My Title');
        $fixture->setProfile_img('My Title');
        $fixture->setBack_img('My Title');
        $fixture->setUsersBlockeds('My Title');
        $fixture->setUsersDeleteds('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/users/');
    }
}
