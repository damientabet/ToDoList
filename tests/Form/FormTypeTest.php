<?php
namespace App\Tests\Form;

use App\Entity\Task;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\TaskType;
use Symfony\Component\Form\Test\TypeTestCase;

class FormTypeTest extends TypeTestCase
{
    public function testCreateTaskSuccessfully()
    {
        $date = new \DateTime;
        $date->setDate('2020', '07', '01');
        $date->setTime('19', '00', '00');

        $formData = [
            'title' => 'test',
            'content' => 'test2',
            'createdAt' => $date
        ];

        $model = new Task();
        $model->setCreatedAt($date);
        // $formData will retrieve data from the form submission; pass it as the second argument
        $form = $this->factory->create(TaskType::class, $model);

        $expected = new Task();
        $expected->setTitle('test');
        $expected->setContent('test2');
        $expected->setCreatedAt($date);
        // ...populate $object properties with the data stored in $formData

        // submit the data to the form directly
        $form->submit($formData);

        // This check ensures there are no transformation failures
        $this->assertTrue($form->isSynchronized());

        // check that $formData was modified as expected when the form was submitted
        $this->assertEquals($expected, $model);
    }

    public function testCreateTaskIsDoneSuccessfully()
    {
        $date = new \DateTime;
        $date->setDate('2020', '07', '01');
        $date->setTime('19', '00', '00');

        $formData = [
            'title' => 'test',
            'content' => 'test2',
            'createdAt' => $date
        ];

        $model = new Task();
        $model->setCreatedAt($date);
        $model->setIsDone(1);
        // $formData will retrieve data from the form submission; pass it as the second argument
        $form = $this->factory->create(TaskType::class, $model);

        $expected = new Task();
        $expected->setTitle('test');
        $expected->setContent('test2');
        $expected->setCreatedAt($date);
        $expected->setIsDone(1);
        // ...populate $object properties with the data stored in $formData

        // submit the data to the form directly
        $form->submit($formData);

        // This check ensures there are no transformation failures
        $this->assertTrue($form->isSynchronized());

        // check that $formData was modified as expected when the form was submitted
        $this->assertEquals($expected, $model);
    }

    public function testCreateUserFormSuccessfully()
    {
        $formData = [
            'username' => 'test',
            'password' => 'test',
            'email' => 'test2',
            'roles' => 'ROLE_USER'
        ];

        $model = new User();
        // $formData will retrieve data from the form submission; pass it as the second argument
        $form = $this->factory->create(RegistrationFormType::class, $model);

        $expected = new User();
        $expected->setUsername('test');
        $expected->setEmail('test2');
        $expected->setRoles(array("ROLE_USER"));
        $expected->setPassword('test');

        // ...populate $object properties with the data stored in $formData
        $model->setPassword($formData['password']);

        // submit the data to the form directly
        $form->submit($formData);

        // This check ensures there are no transformation failures
        $this->assertTrue($form->isSynchronized());

        // check that $formData was modified as expected when the form was submitted
        $this->assertEquals($expected, $model);
    }
}
