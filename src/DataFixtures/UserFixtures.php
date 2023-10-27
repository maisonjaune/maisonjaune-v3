<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use FOS\UserBundle\Model\UserManagerInterface;

class UserFixtures extends AppFixtures
{
    public function __construct(
        private UserManagerInterface $userManager,
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->getData() as $data) {
            $entity = $this->userManager->createUser();

            if ($entity instanceof User) {
                $entity
                    ->setUsername((string) $data['username'])
                    ->setEmail((string) $data['email'])
                    ->setFirstname((string) $data['firstname'])
                    ->setLastname((string) $data['lastname'])
                    ->setPlainPassword('azerty')
                    ->setEnabled(!!$data['enabled'])
                    ->setAdmin(!!$data['admin'])
                    ->setSuperAdmin(!!$data['super_admin']);
            }

            $this->setReference((string) $data['username'], $entity);

            $this->userManager->updateUser($entity);
        }

        $manager->flush();
    }

    /**
     * @return array<array<string, bool|string|null>>
     */
    private function getData(): array
    {
        return [
            [
                'username' => 'superadmin',
                'email' => 'super.admin@mail.test',
                'firstname' => 'Utilisateur',
                'lastname' => 'Super Admin',
                'enabled' => true,
                'admin' => true,
                'super_admin' => true,
            ],
            [
                'username' => 'admin',
                'email' => 'admin@mail.test',
                'firstname' => 'Utilisateur',
                'lastname' => 'Admin',
                'enabled' => true,
                'admin' => true,
                'super_admin' => false,
            ],
            [
                'username' => 'redacteur01',
                'email' => 'redacteur01@mail.test',
                'firstname' => 'Utilisateur',
                'lastname' => 'Rédacteur 01',
                'enabled' => true,
                'admin' => true,
                'super_admin' => false,
            ],
            [
                'username' => 'redacteur02',
                'email' => 'redacteur02@mail.test',
                'firstname' => 'Utilisateur',
                'lastname' => 'Rédacteur 02',
                'enabled' => true,
                'admin' => true,
                'super_admin' => false,
            ],
            [
                'username' => 'redacteur03',
                'email' => 'redacteur03@mail.test',
                'firstname' => 'Utilisateur',
                'lastname' => 'Rédacteur 03',
                'enabled' => true,
                'admin' => true,
                'super_admin' => false,
            ],
            [
                'username' => 'enabled.user',
                'email' => 'enabled.user@mail.test',
                'firstname' => 'Utilisateur',
                'lastname' => 'Enabled',
                'enabled' => true,
                'admin' => false,
                'super_admin' => false,
            ],
            [
                'username' => 'disabled.user',
                'email' => 'disabled.user@mail.test',
                'firstname' => 'Utilisateur',
                'lastname' => 'Disabled',
                'enabled' => false,
                'admin' => false,
                'super_admin' => false,
            ],
        ];
    }
}
