<?php

namespace App\Http\Controllers\Notice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notice;
class NoticeController extends Controller
{
    protected $_module;
    protected $_routePrefix;
    protected $_model;

    public function __construct()
    {
        $this->_module      = 'Notice';
        $this->_routePrefix = 'admin.notices';
        $this->_model       = new Notice();
    }

    public function index()
    {
        $notices = Notice::all();
        dd($notices);
        return view($this->_routePrefix . '.index', compact('notices'));
    }
}
