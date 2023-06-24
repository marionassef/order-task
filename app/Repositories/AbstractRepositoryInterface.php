<?php


namespace App\Repositories;


interface AbstractRepositoryInterface
{
    public function create($data);

    public function update($item, $data);

    public function updateOrCreate($itemIfExist, $data);

    public function findAll($filters = [], $with = [], $returnResults = true,$orderBy = 'id',$direction = 'DESC');

    public function findAllByWhereIn($colummn , $value, $with = [], $returnResults = true,$orderBy = 'id',$direction = 'DESC');
    
    public function findOneByWhereIn($colummn , $value, $with = []);

    public function findAllByWhereNotIn($colummn , $value, $with = [], $returnResults = true,$orderBy = 'id',$direction = 'DESC');

    public function findAllWithPaging($filters = [], $with = [], $limit = 10, $offset = 0, $returnResults = true,$orderBy = 'id',$direction = 'DESC');

    public function findOneBy($filters = [], $with = []);

    public function findOneByOrFail($filters = [], $with = []);

    public function delete($id);

    public function getItem($idOrModel);

    public function firstOrCreate($data);

    public function sync($item,$modelRelation,$data);

    public function deleteCollection($filters);
}
