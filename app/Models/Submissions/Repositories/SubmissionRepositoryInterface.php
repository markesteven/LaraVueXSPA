<?php

namespace App\Models\Submissions\Repositories;

use App\Models\Base\BaseRepositoryInterface;
use App\Models\Submissions\Submission;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

interface SubmissionRepositoryInterface extends BaseRepositoryInterface
{
    public function createSubmission(array $data);

    public function confirmSubmission(array $data);

    public function findSubmissionById(int $id) : Submission;

    public function listSubmissions($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection;

    function getAllSubmissions(Request $request);
}
