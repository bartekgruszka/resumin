#language: en

  @database
  Feature: Sign in to the manager
    In order to access the administrative area
    As a anonymous user
    I need to be able to log in using login form

    Background:
      Given there are following users:
        | username | email          | password   | enabled |
        | test     | test@test.com  | testpass   | yes     |
        | test2    | test@test2.com | test2pass  | no      |


    Scenario: Log in with username and password
      Given I am on "/manager/login"
      When I fill in the following:
        | username | test     |
        | password | testpass |
      And I press "Login"
      Then I should be on "/manager"

    Scenario: Log in with email and password
      Given I am on "/manager/login"
      When I fill in the following:
        | username | test@test.com |
        | password | testpass      |
      And I press "Login"
      Then I should be on "/manager"


    Scenario: Log in with "Remember me" checked
      Given I am on "/manager/login"
      When I fill in the following:
        | username | test     |
        | password | testpass |
      And I check "Remember me"
      And I press "Login"
      Then I should be on "/manager"
      And cookie "REMEMBERME" should exist

    Scenario: Log in with disabled account
      Given I am on "/manager/login"
      When I fill in the following:
        | username | test2     |
        | password | test2pass |
      And I press "Login"
      Then I should be on "/manager/login"
      And I should see "User account is disabled"

    Scenario: Log in with bad credentials
      Given I am on "/manager/login"
      When I fill in the following:
        | username | test@test.com |
        | password | badpass       |
      And I press "Login"
      Then I should be on "/manager/login"
      And I should see "Bad credentials"
