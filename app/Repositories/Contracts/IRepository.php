<?php
/**
 * Created by PhpStorm.
 * User: dev03
 * Date: 30/04/17
 * Time: 16:13
 */

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;

interface IRepository
{
    public function create(array $attributes);

    public function update(array $attributes, $value, $field);

    public function lists($columns=['*']);

    public function delete($id);

    public function find($id, $columns=['*']);

    public function findBy($field, $value, $columns = ['*']);

    public function findWhere(array $where, $columns = ['*']);

    public function deleteWhere(array $where);

    public function with($relations);

    public function count();

    public function scopeQuery(\Closure $scope);

    public function resetScope();

    public function getSearchableFields();

    public function sync($id, $relation, $attribute, $detaching);

    public function syncWithoutDetaching($id, $relation, $attribute);
}
