<?php

namespace APOSite\Models\Contracts;

use APOSite\Models\Users\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use League\Fractal\Manager;

interface ReportInterface
{
    public function transformer(Manager $manager);

    public function computeValue(array $brotherData);

    public function getTag(array $brotherData);

    public function createRules();

    public function updateRules();

    public function errorMessages();

    public function canStore(User $user);

    public static function applyRowLevelSecurity(QueryBuilder $query, User $user);

    public static function applyReportFilters(QueryBuilder $query);

    public function canUpdate(User $user);

    public function canRead(User $user);

    public function updatable();
}