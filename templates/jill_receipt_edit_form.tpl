<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/My97DatePicker/WdatePicker.js"></script>

<!--套用formValidator驗證機制-->
<form action="<{$action}>" method="post" id="myForm" enctype="multipart/form-data" class="form-horizontal" role="form">
    <!--入款帳戶-->
    <div class="form-group row">
      <label class="col-sm-2 control-label col-form-label text-md-right">
        <{$smarty.const._MD_JILLRECEIP_ACCOUNT}>
      </label>
      <div class="col-sm-6">
        <select name="account" id="account" class="form-control" size=1>
          <{foreach from=$accountArr key=k item=t}>
            <option value=<{$k}> <{if $def_account==$k}>selected<{/if}> ><{$t}></option>
          <{/foreach}>
        </select>
      </div>
    </div>

    <!--補助單位編號-->
    <div class="form-group row">
      <label class="col-sm-2 control-label col-form-label text-md-right">
        <{$smarty.const._MD_JILLRECEIP_UNIT}>
      </label>
      <div class="col-sm-6">
        <select name="usn" class="form-control " size=1>
          <{foreach from=$usn_options item=opt}>
            <option value="<{$opt.usn}>" <{if $def_usn==$opt.usn}>selected<{/if}>><{$opt.unit}></option>
          <{/foreach}>
        </select>
      </div>
    </div>

    <!--補助事由-->
    <div class="form-group row">
      <label class="col-sm-2 control-label col-form-label text-md-right">
        <{$smarty.const._MD_JILLRECEIP_TITLE}>
      </label>
      <div class="col-sm-10">
        <textarea name="title" rows=8 id="title" class="form-control validate[required] " placeholder="<{$smarty.const._MD_JILLRECEIP_TITLE}>"><{$title}></textarea>
      </div>
    </div>

    <!--金額-->
    <div class="form-group row">
      <label class="col-sm-2 control-label col-form-label text-md-right">
        <{$smarty.const._MD_JILLRECEIP_AMOUNT}>
      </label>
      <div class="col-sm-10">
        <input type="text" name="amount" id="amount" class="form-control validate[required,custom[onlyNumber]] " value="<{$amount}>" placeholder="<{$smarty.const._MD_JILLRECEIP_AMOUNT}>">
      </div>
    </div>

  <div class="text-center">

        <!--申請人員-->
        <input type='hidden' name="uid" value="<{$uid}>">

    <{$token_form}>

    <input type="hidden" name="op" value="<{$next_op}>">
    <input type="hidden" name="rsn" value="<{$rsn}>">
    <button type="submit" class="btn btn-primary"><{$smarty.const._TAD_SAVE}></button>
  </div>
</form>
