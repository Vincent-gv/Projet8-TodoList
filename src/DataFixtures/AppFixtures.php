<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @codeCoverageIgnore
 * Class AppFixtures
 * @package App\DataFixtures
 */
class AppFixtures extends Fixture
{
    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        $userAdmin = new User();

        $userAdmin->setEmail("admin@admin.com");
        $userAdmin->setUsername("admin");
        $userAdmin->setPassword($this->encoder->encodePassword($userAdmin, "admin"));
        $userAdmin->setRoles(array('ROLE_ADMIN'));

        $manager->persist($userAdmin);

        $userUser = new User();

        $userUser->setEmail("user@user.com");
        $userUser->setUsername("user");
        $userUser->setPassword($this->encoder->encodePassword($userUser, "user"));
        $userUser->setRoles(array('ROLE_USER'));

        $manager->persist($userUser);

        $users = [];
        array_push($users, $userAdmin, $userUser);
        //$users[] = $userAdmin $userUser;

        for($j = 0; $j < 5; $j++){
            $user = new User();

            $user->setUsername($faker->userName);
            $user->setPassword($this->encoder->encodePassword($user, "user"));
            $user->setEmail($faker->safeEmail);
            $user->setRoles(array('ROLE_USER'));

            $users[] = $user;

            $manager->persist($user);
        }

        for($i = 0; $i < 5; $i++){
            $task = new Task();

            try {
                $task->setUser($users[random_int(0, count($users) - 1)]);
            } catch (Exception $e) {
            }
            $task->setIsDone(false);
            $task->setCreatedAt( $faker->dateTime("-8 hours") );
            $task->setTitle($faker->word());
            $task->setContent($faker->paragraph(1));

            $manager->persist($task);
        }

        for($f = 0; $f < 3; $f++){
            $anonTask = new Task();

            $anonTask->setIsDone(false);
            $anonTask->setCreatedAt( $faker->dateTime("-8 hours") );
            $anonTask->setContent($faker->paragraph(1));
            $anonTask->setTitle($faker->word());
            $anonTask->setUser(null);

            $manager->persist($anonTask);
        }

        $manager->flush();
    }
}