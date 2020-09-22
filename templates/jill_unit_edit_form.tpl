<!--套用formValidator驗證機制-->
<form action="<{$action}>" method="post" id="myForm" enctype="multipart/form-data" class="form-horizontal" role="form">
    <!--補助單位-->
    <div class="form-group row">
      <label class="col-sm-2 control-label col-form-label text-md-right">
        <{$smarty.const._MD_JILLRECEIP_UNIT}>
      </label>
      <div class="col-sm-10">
        <input type="text" name="unit" id="unit" class="form-control validate[required]" value="<{$unit}>" placeholder="<{$smarty.const._MD_JILLRECEIP_UNIT}>">
      </div>
    </div>

    <!--單位代碼-->
    <div class="form-group row">
      <label class="col-sm-2 control-label col-form-label text-md-right">
        <{$smarty.const._MD_JILLRECEIP_UNIT_CODE}>
      </label>
      <div class="col-sm-10">
        <input type="text" name="unit_code" id="unit_code" class="form-control " value="<{$unit_code}>" placeholder="<{$smarty.const._MD_JILLRECEIP_UNIT_CODE}>">
      </div>
    </div>

    <!--排序-->
    <div class="form-group row">
      <label class="col-sm-2 control-label col-form-label text-md-right">
        <{$smarty.const._MD_JILLRECEIP_SORT}>
      </label>
       <div class="col-sm-2">
        <input type="text" name="sort" id="sort" class="form-control " value="<{$sort}>" placeholder="<{$smarty.const._MD_JILLRECEIP_SORT}>">
      </div>
    </div>

  <div class="text-center">

        <!--補助單位編號-->
        <input type='hidden' name="usn" value="<{$usn}>">

    <{$token_form}>

    <input type="hidden" name="op" value="<{$next_op}>">
    <input type="hidden" name="usn" value="<{$usn}>">
    <button type="submit" class="btn btn-primary"><{$smarty.const._TAD_SAVE}></button>
  </div>
</form>
