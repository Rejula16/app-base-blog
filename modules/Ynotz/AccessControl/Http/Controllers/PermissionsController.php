<?php

namespace Modules\Ynotz\AccessControl\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Ynotz\AccessControl\Models\Permission;
use Modules\Ynotz\AccessControl\Services\PermissionService;
use Modules\Ynotz\SmartPages\Http\Controllers\SmartController;
use Modules\Ynotz\AccessControl\Http\Requests\PermissionsStoreRequest;
use Modules\Ynotz\EasyAdmin\Traits\HasMVConnector;

class PermissionsController extends SmartController
{
    use HasMVConnector;

    public function __construct(PermissionService $connectorService, Request $request){
        parent::__construct($request);
        $this->connectorService = $connectorService;
        // $this->itemName = 'districts';
        // $this->indexView = 'easyadmin::admin.indexpanel';
        // $this->createView = 'accesscontrol::roles.create';
        // $this->editView = 'accesscontrol::roles.edit';
    }
}
