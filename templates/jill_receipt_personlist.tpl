<{$delete_jill_receipt_func}>
<table class="table table-striped table-hover">
  <thead>
    <tr class="info">

      <th>
        <!--入款帳戶-->
        <{$smarty.const._MD_JILLRECEIP_ACCOUNT}>
      </th>
      <th>
        <!--補助單位編號-->
        <{$smarty.const._MD_JILLRECEIP_UNIT}>
      </th>
      <th>
        <!--事由-->
        <{$smarty.const._MA_JILLRECEIP_TITLE}>
      </th>
      <th>
        <!--金額-->
        <{$smarty.const._MD_JILLRECEIP_AMOUNT}>
      </th>
      <th>
        <!--是否製單-->
        <{$smarty.const._MD_JILLRECEIP_STATUS}>
      </th>
      <th><{$smarty.const._TAD_FUNCTION}></th>
    </tr>
  </thead>

  <tbody id="jill_receipt_sort">
    <{foreach from=$all_content item=data}>
      <tr id="tr_<{$data.rsn}>" >
        <td>
          <!--入款帳戶-->
          <{$data.account}>
        </td>

        <td>
          <!--補助單位編號-->
          <{$data.usn}>
        </td>

        <td>
          <!--事由-->
          <{$data.title}>
        </td>

        <td>
          <!--金額-->
          <{$data.amount}>
        </td>
        <!--是否製單-->
        <td id="status:<{$data.rsn}>" class="jq_select"><{$data.status_name}></td>
        <td>
          <{if $data.status=='0' || $data.status==''}>
            <a href="javascript:delete_jill_receipt_func(<{$data.rsn}>);" class="btn btn-xs btn-danger"><{$smarty.const._TAD_DEL}></a>
            <a href="<{$xoops_url}>/modules/jill_receipt/index.php?op=jill_receipt_form&rsn=<{$data.rsn}>" class="btn btn-xs btn-warning"><{$smarty.const._TAD_EDIT}></a>
          <{/if}>
        </td>
      </tr>
    <{/foreach}>
  </tbody>
</table>
<div class="text-right">
  <a href="<{$xoops_url}>/modules/jill_receipt/index.php?op=jill_receipt_form&usn=<{$usn}>" class="btn btn-info"><{$smarty.const._TAD_ADD}></a>
</div>
<{$bar}>