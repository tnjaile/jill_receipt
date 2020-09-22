<{if $all_content}>
  <div class="responsive">
    <table class="table table-striped table-hover">
      <thead>
        <tr class="info">

          <th class="col-sm-1">
            <!--入款帳戶-->
            <{$smarty.const._MD_JILLRECEIP_ACCOUNT}>
          </th>
          <th class="col-sm-1">
            <!--補助單位編號-->
            <{$smarty.const._MD_JILLRECEIP_UNIT}>
          </th>
          <th class="col-sm-2">
            <!--事由-->
            <{$smarty.const._MA_JILLRECEIP_TITLE}>
          </th>
          <th class="col-sm-1">
            <!--金額-->
            <{$smarty.const._MD_JILLRECEIP_AMOUNT}>
          </th>
          <th class="col-sm-1">
            <!--申請人員-->
            <{$smarty.const._MD_JILLRECEIP_UID}>
          </th>
          <th class="col-sm-1">
            <!--是否製單-->
            <{$smarty.const._MD_JILLRECEIP_STATUS}>
          </th>

          <th class="col-sm-2">
            <!--收入日期-->
            <{$smarty.const._MD_JILLRECEIP_IN_DATE}>
          </th>
          <th class="col-sm-1">
            <!--統一編號-->
            <{$smarty.const._MD_JILLRECEIP_TAX_ID}>
          </th>
          <!--備註-->
          <th class="col-sm-2">
            <{$smarty.const._MD_JILLRECEIP_NOTE}>
          </th>
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
            <td >
              <{$data.uid_name}>
            </td>

            <!--是否製單-->
            <td id="status:<{$data.rsn}>" class="jq_select"><{$data.status_name}></td>

            <td id="in_date:<{$data.rsn}>" class="jq_date"><{$data.in_date}></td>

            <td id="tax_id:<{$data.rsn}>" class="jq_tax"><{$data.tax_id}></td>
            <td id="note:<{$data.rsn}>" class="jq_note"><{$data.note}></td>
          </tr>
        <{/foreach}>
      </tbody>
    </table>
  </div>
<{else}>
  <div class="jumbotron text-center">
      <h3><{$smarty.const._MD_JILLRECEIP_NODATA}></h3>
  </div>
<{/if}>