<?php

namespace App\Models\ArchiveDocuments;

use App\Models\Tasks\Task;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;

class ArchiveDocument extends Model
{
    use HasFactory, SoftDeletes, HasUuids, Filterable;

    protected $fillable = [
        'short_description',
        'path',
        'comment',
        'incoming_at',
        'incoming_number',
        'incoming_author',
        'number',
        'date',
        'document_and_application_sheets',
        'file_mark',
        'executed_result',
        'executed_at',
        'author_uuid',
        'archive_path',
    ];

    public function __construct(array $attributes = [], $tableName = 'files')
    {
        parent::__construct($attributes);

        $this->table = $tableName;

            //$time = strtotime("-2 year", time());
            //$date = date("Y", $time);

            //$this->table = Schema::hasTable('archive_files_' . $date) ? 'archive_files_' . $date : 'files';

    }

    protected function setTableName(string $tableName = 'files')
    {
        $this->table = $tableName;
    }

    protected function getTableName()
    {
        return $this->table;
    }

    public function tasks()
    {
        return $this->belongsToMany(
            Task::class,
            'task_files',
            'file_uuid',
            'task_uuid'
        )->wherePivot('deleted_at', null);
    }

    protected function removeQueryParam(string ...$keys)
    {
        foreach ($keys as $key) {
            unset($this->queryParams[$key]);
        }

        return $this;
    }

    public function getAllByYear(string $year)
    {
        return DB::select('select * from archive_files_' . $year);
    }

    public function getOneByIdAndYear(string $id, string $year)
    {
        return DB::table('archive_files_' . $year)
            ->where('id', 'LIKE', '%' . $id . '%')
            ->first();
    }

    public function updateByIdAndYear(string $id, string $year, array $data)
    {
        return   DB::table('archive_files_' . $year)
            ->where('id', $id)
            ->update(array(
                'incoming_at' => $data['incoming_at'],
                'incoming_number'=>$data['incoming_number'],
                'short_description' => $data['short_description'],
                'incoming_author' => $data['incoming_author'],
                'number' => $data['number'],
                'date' => $data['date'],
                'document_and_application_sheets' => $data['document_and_application_sheets'],
                'file_mark' => $data['file_mark'],
            ));
    }

    public function deleteByIdAndYear(string $id, string $year)
    {
        DB::table('archive_files_' . $year)->delete($id);
    }

    public function searchByContent(string $year, string $content)
    {
        return DB::select("SELECT *
                                    FROM archive_files_" . $year . "
                                    WHERE MATCH (content) AGAINST ('$content' )");
    }
}
