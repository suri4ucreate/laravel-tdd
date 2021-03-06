<?php

namespace Tests\Unit;

use Tests\ParentTestClass;
use App\Components\CustomQueryBuilder;

class QueryBuilderTest extends ParentTestClass
{

    public function setup():void
    {

    }

    public function testSelectQuery()
    {
        $sql = new CustomQueryBuilder();
        $this->assertEquals('select * from products', $sql->select('products'));
    }

    public function testSelectSpecificColumnsQuery()
    {
        $sql = new CustomQueryBuilder();
        $this->assertEquals('select id, name from products', $sql->select('products', ['id', 'name']));
    }

    public function testSelectSpecificColumnsWithOrderByQuery()
    {
        $sql = new CustomQueryBuilder();
        $this->assertEquals('select id, name from products order by id desc', $sql->select('products', ['id', 'name'], ['id', 'desc']));
    }

    public function testSelectWithMultipleColumnOrderByQuery()
    {
        $sql = new CustomQueryBuilder();
        $this->assertEquals('select * from products order by name asc, category asc',
                            $sql->select('products', [['name', 'asc'],['category','asc']]));
    }

    public function testSelectSpecificColumnsOrderByCapitalKeywordsQuery()
    {
        $sql = new CustomQueryBuilder();
        $this->assertEquals('SELECT id, name FROM products ORDER BY id DESC', $sql->select('products', ['id', 'name'], ['id', 'DESC']));
    }

    public function testSelectWithLimitQuery()
    {
        $sql = new CustomQueryBuilder();
        $this->assertEquals('select * from products limit 10', $sql->select('products', 10));
    }

    public function testSelectWithLimitAndOffesetQuery()
    {
        $sql = new CustomQueryBuilder();
        $this->assertEquals('select * from products limit 6 offset 5', $sql->select('products', [6, 5]));
    }

    public function testSelectCountQuery()
    {
        $sql = new CustomQueryBuilder();
        $this->assertEquals('select count("id") from products', $sql->select('products', ['count','id']));
    }

    public function testSelectMaxQuery()
    {
        $sql = new CustomQueryBuilder();
        $this->assertEquals('select max("cost") from products', $sql->select('products', ['max','cost']));
    }

    public function testSelectWithDistinct()
    {
        $sql = new CustomQueryBuilder();
        $this->assertEquals('select DISTINCT name from products', $sql->select('products', ['DISTINCT','name']));
    }

    public function testSelectWithJoinOtherTables()
    {
        $sql = new CustomQueryBuilder();
        $this->assertEquals('select * from products join categories on products.category_id=categories.id',
                            $sql->select('products', 'categories', ['id', 'category_id']));
    }

    public function testInsertWithSecificColumns()
    {
        $sql = new CustomQueryBuilder();
        $this->assertEquals('INSERT INTO products("id", "name", "cost", "color") VALUES(1, "apple", 100, "red")',
                            $sql->insert('products', ["id","name","cost","color"], [1, "apple", 100, "red"]));
    }

    public function testInsertMultipleRowsWithSecificColumns()
    {
        $sql = new CustomQueryBuilder();
        $this->assertEquals(
            'INSERT INTO products("id", "name", "cost", "color") VALUES(1, "apple", 100, "red"), (2, "orange", 50, "orange")',
            $sql->insert('products', ["id", "name","cost","color"], [[1, "apple", 100, "red"],[2, "orange", 50, "orange"]] ));
    }

    public function testInsertRowWithSecificColumnsAndDefaultValue()
    {
        $sql = new CustomQueryBuilder();
        $this->assertEquals('INSERT INTO products("id", "name", "cost", "color") VALUES(1, "apple", 100, DEFAULT)',
                            $sql->insert('products', ["id","name","cost","color"], [1, "apple", 100, 'DEFAULT']));
    }
}
