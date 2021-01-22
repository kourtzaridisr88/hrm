<?php

use Hr\Infrastructure\Database\Database;
use Laminas\Diactoros\ServerRequest;

use Hr\Domain\Department\Contracts\DepartmentRepositoryInterface;
use Hr\Domain\Department\Repositories\DBDepartmentRepository;
use Hr\Domain\Department\Contracts\EmployeeRepositoryInterface;
use Hr\Domain\Department\Repositories\DBEmployeeRepository;

use Hr\Domain\Organization\Contracts\OrganizationRepositoryInterface;
use Hr\Domain\Organization\Repositories\DBOrganizationRepository;
use Hr\Domain\Organization\Contracts\UserRepositoryInterface;
use Hr\Domain\Organization\Repositories\DBUserRepository;

use function DI\create;
use function DI\get;

return [
    ServerRequest::class => get('request'),
    DepartmentRepositoryInterface::class => create(DBDepartmentRepository::class),
    EmployeeRepositoryInterface::class => create(DBEmployeeRepository::class),
    OrganizationRepositoryInterface::class => create(DBOrganizationRepository::class),
    UserRepositoryInterface::class => create(DBUserRepository::class)
];
