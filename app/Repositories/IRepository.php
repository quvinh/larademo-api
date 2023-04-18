<?php

namespace App\Repositories;

use App\Helpers\Common\MetaInfo;
use App\Helpers\Filters\BasicFilter;
use Illuminate\Database\Eloquent\Builder;

interface IRepository
{
    /**
     * get corresponding model class name
     * @return string
     */
    function getRepositoryModelClass(): string;

    /**
     * Search model items using a given basic filter (context filter) or return a query builder
     * @param BasicFilter $filter
     * @param bool $onlyActive
     * @return Builder
     */
    function search(BasicFilter $filter, bool $onlyActive = true): Builder;

    /**
     * Find a single object base on its id
     * @param mixed $id
     * @param string $id_column_name
     * @return mixed
     */
    function getSingleObject(mixed $id, string $id_column_name = 'id'): mixed;

    /**
     * Try to create the object using the given info
     * @param array<string, mixed> $form
     * @param MetaInfo|null $meta
     * @return mixed
     */
    function create(array $form, MetaInfo $meta = null, string $id_column_name = 'id'): mixed;

    /**
     * Try to save the object using the given info
     * @param array<mixed> $form
     * @param MetaInfo|null $meta
     * @param string $id_column_name
     * @return mixed
     */
    function update(array $form, MetaInfo $meta = null, string $id_column_name = 'id'): mixed;

    /**
     * Try to delete a model based on its id
     * @param mixed $id
     * @param bool $soft
     * @param MetaInfo|null $meta
     * @return bool
     */
    function delete(mixed $id, bool $soft = false, MetaInfo $meta = null, string $id_column_name = 'id'): bool;

    /**
     * Try to restore a model record
     * @param mixed $id
     * @param bool $soft
     * @param MetaInfo|null $meta
     * @param string $id_column_name
     * @return bool
     */
    function restore(mixed $id, bool $soft = false, MetaInfo $meta = null, string $id_column_name = 'id'): bool;

    /**
     * Try to count matched items based on the given filter
     * @param BasicFilter|null $filter
     * @param bool $onlyActive
     * @return int
     */
    function count(BasicFilter $filter = null, bool $onlyActive = true): int;

    /**
     * Query by applying a filter condition on a field name
     * @param array<mixed>|null $condition
     * @param Builder|null $query
     * @return Builder
     */
    function queryOnAField(array $condition = null, Builder $query = null, array $positional_bindings = null): Builder;

    /**
     * Add extra relationship field to query
     * @param array<string> $withs
     * @param Builder|null $query
     * @return Builder
     */
    function withs(array $withs, Builder $query = null): Builder;
}
