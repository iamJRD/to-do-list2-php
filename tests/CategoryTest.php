<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Category.php";

    $server = 'mysql:host=localhost;dbname=to_do_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CategoryTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
          Category::deleteAll();
          Task::deleteAll();
        }


        function testGetName()
        {
            //Arrange
            $name = "Work stuff";
            $test_category = new Category($name);

            //Act
            $result = $test_category->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function testGetId()
        {
            //Arrange
            $name = "Work stuff";
            $id = 1;
            $test_category = new Category($name, $id);

            //Act
            $result = $test_category->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function testSave()
        {
            //Arrange
            $name = "Work stuff";
            $test_category = new Category($name);
            $test_category->save();

            //Act
            $result = Category::getAll();

            //Assert
            $this->assertEquals($test_category, $result[0]);
        }

        function testGetAll()
        {
            //Arrange
            $name = "Work stuff";
            $test_category = new Category($name);
            $test_category->save();

            $name2 = "Home stuff";
            $test_category2 = new Category($name2);
            $test_category2->save();

            //Act
            $result = Category::getAll();

            //Assert
            $this->assertEquals([$test_category, $test_category2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $name = "Wash the dog";
            $test_category = new Category($name);
            $test_category->save();

            $name2 = "Home stuff";
            $test_category2 = new Category($name2);
            $test_category2->save();

            //Act
            Category::deleteAll();
            $result = Category::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function testFind()
        {
            //Arrange
            $name = "Wash the dog";
            $test_category = new Category($name);
            $test_category->save();

            $name2 = "Home stuff";
            $test_category2 = new Category($name2);
            $test_category2->save();

            //Act
            $result = Category::find($test_category->getId());

            //Assert
            $this->assertEquals($test_category, $result);
        }

        function testAddTask()
        {
            // Arrange
            $name = "Work stuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "File reports";
            $due_date = "2016-03-01";
            $test_task = new Task($description, $id, $due_date);
            $test_task->save();

            // Act
            $test_category->addTask($test_task);

            // Assert
            $this->assertEquals($test_category->getTasks(), [$test_task]);
        }

        function testGetTasks()
        {
            //Arrange;
            $name = "Home stuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $due_date = "2016-03-01";
            $test_task = new Task($description, $id, $due_date);
            $test_task->save();

            $description2 = "Take out the trash";
            $test_task2 = new Task($description2, $id, $due_date);
            $test_task2->save();

            //Act;
            $test_category->addTask($test_task);
            $test_category->addTask($test_task2);

            //Assert
            $this->assertEquals($test_category->getTasks(), [$test_task, $test_task2]);
        }

        function testDelete()
        {
            // Arrange
            $name = "Work stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $name2 = "Home stuff";
            $test_category2 = new Category($name2, $id);
            $test_category2->save();

            // Act
            $test_category->delete();

            // Assert
            $this->assertEquals([$test_category2], Category::getAll());
        }

        function testUpdate()
        {
            //Arrange;
            $name = "Work stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();
            $new_name = "Home Stuff";

            //Act;
            $test_category->update($new_name);
            $result = $test_category->getName();

            //Assert;
            $this->assertEquals($new_name, $result);
        }
    }

?>
