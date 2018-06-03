<?php

interface DBinterface
{
    public function Execute($query);
    public function Insert($data);
    public function Delete($where='');
    public function Update($data,$where='');
    public function GetRows();
    public function GetRow();
    public function AffectedRows();

}