<?php

use League\Fractal\Manager;
use APOSite\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

interface ReportInterface {
    public function transformer(Manager $manger);
    public function computeValue(array $brotherData);
    public function createRules();
    public function updateRules();
    public function errorMessages();
    public function onCreate();
    public function onUpdate();
    public function canStore(User $user);
    public static function applyRowLevelSecurity(QueryBuilder $query, User $user);
    public static function applyReportFilters(QueryBuilder $query);
    public function canUpdate(User $user);
    public function canRead(User $user);
}