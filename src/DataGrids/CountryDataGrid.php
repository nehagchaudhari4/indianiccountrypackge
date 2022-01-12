<?php

namespace Indianiic\Country\DataGrids;

use Indianiic\LaravelDataGrid\LaravelDataGrid;
use DB;

class CountryDataGrid extends LaravelDataGrid
{
    public $guard = 'admin';
    /**
     * Define unique table id
     * @var mixed $uniqueID
     */
    public $uniqueID = 'countries';

    /**
     * Define how many rows you want to display on a page
     * @var int $rowPerPage
     */
    public $recordsPerPage = 10;

    /**
     * Define row per page dropdown options
     * @var array $recordsPerPageOptions
     */
    public $recordsPerPageOptions;

    /**
     * Define mysql column name which you want to default on sorting
     * @var string $sortBy
     */
    public $sortBy;

    /**
     * Define default soring direction
     * Example: ASC | DESC
     * @var string $sortByDirection
     */
    public $sortByDirection;

    /**
     * Set download file prefix or set false
     * @var mixed
     */
    protected $downloadFilePrefix = 'countries';

    /**
     * Get Resource of Query Builder
     */
    public function resource()
    {
        return DB::table('countries');
    }

    /**
     * Get Columns with key value
     */
    public function columns(): array
    {
        return [
            'country_code' => 'Country Code',
            'name' => 'Name',
            'phone_code' => 'Phone Code',
            'status' => 'Status',
            'action' => 'Action'
        ];
    }

    /**
     * Return columns id which you want to allow on sorting
     * @return array
     */
    public function sortableColumns(): array
    {
        return [
            'country_code',
            'name',
            'phone_code',
            'status',
        ];
    }

    /**
     * Return columns id with label which you want to allow on download
     * @return array
     */
    public function downloadableColumns(): array
    {
        return [
            'country_code' => 'Country Code',
            'name' => 'Name',
            'phone_code' => 'Phone Code',
            'status_download' => 'Status',
        ];
    }

    /**
     * Return columns id with data type which you want to allow on searching
     * @return array
     */
    public function searchableColumns(): array
    {
        return [
            'country_code' => 'string',
            'name' => 'string',
            'phone_code' => 'string',
            'status' => getEnumValues('countries', 'status'),
        ];
    }

    /**
     * Get status column data on downloading
     *
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function getColumnStatusDownload($data)
    {
        return  $data['status'];
    }

    /**
     * Return columns status with toggle UI
     */
    public function getColumnStatus($data)
    {
        return '<div class="custom-control custom-switch light">
                    <input type="checkbox" class="custom-control-input change-status" data-id = "' . $data['id'] . '" id="switchCheckbox' . $data['id'] . '" ' . (($data['status'] == 'Active') ? 'checked' : '') . '>
                    <label class="custom-control-label" for="switchCheckbox' . $data['id'] . '"></label>
                </div>';
    }

    /**
     * Return
     * @return string
     */
    public function getColumnAction($data)
    {
        return $return = '<a class="cursor-pointer mr-3" href="' . route(
            'admin.countries.edit',
            encrypt($data['id'])
        ) . '"><i class="bx bx-edit"></i></a>';
    }
}
