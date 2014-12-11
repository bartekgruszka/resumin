<?php

namespace Resumin\Bundle\ManagerBundle\Features\Context;

use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\MinkExtension\Context\MinkContext;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use SensioLabs\Behat\PageObjectExtension\PageObject\Factory as PageObjectFactory;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Symfony2Extension\Context\KernelDictionary;

class BaseContext extends MinkContext implements SnippetAcceptingContext
{
    /**
     * Provides getKernel() and getContainer()
    */
    use KernelDictionary;

    /**
     * @BeforeScenario @database
     */
    public function purgeDatabase()
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $ormPurger = new ORMPurger($em);
        $ormPurger->purge();
    }

    /**
     * @Given there are following users:
     */
    public function thereIsFollowingUser(TableNode $table)
    {
        $userManager = $this->getContainer()->get('fos_user.user_manager');

        foreach ($table->getHash() as $hash) {
            $user = $userManager->createUser();
            $user->setUsername($hash['username']);
            $user->setPlainPassword($hash['password']);
            $user->setEmail($hash['email']);
            $user->setEnabled($hash['enabled'] === "yes");
            $userManager->updateUser($user);
        }
    }

    /**
     * @Then cookie :cookieName should exist
     */
    public function cookieShouldExist($cookieName)
    {
        if(!$this->getSession()->getCookie($cookieName)) {
            throw new \InvalidArgumentException(sprintf('Cookie "%s" does not exists', $cookieName));
        }
    }
}
