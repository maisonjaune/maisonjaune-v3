<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use FOS\UserBundle\Model\UserManagerInterface;
use RuntimeException;

class UserCrudController extends AbstractCrudController
{
    public function __construct(
        private UserManagerInterface $userManager
    )
    {
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield FormField::addColumn(8);
        yield FormField::addFieldset();

        yield TextField::new('username');

        yield TextField::new('email');

        yield TextField::new('password')
            ->onlyOnForms();

        yield FormField::addColumn(4);
        yield FormField::addFieldset();

        yield BooleanField::new('enabled');

        yield BooleanField::new('admin');

        yield DateTimeField::new('lastLogin')
            ->hideOnForm();
    }

    public function createEntity(string $entityFqcn): User
    {
        $user = $this->userManager->createUser();

        if (!$user instanceof User) {
            throw new RuntimeException('User must be an instance of ' . User::class);
        }

        return $user;
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param User $entityInstance
     * @return void
     */
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->userManager->updateUser($entityInstance);
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param User $entityInstance
     * @return void
     */
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->userManager->updateUser($entityInstance);
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param User $entityInstance
     * @return void
     */
    public function deleteEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->userManager->deleteUser($entityInstance);
    }
}
