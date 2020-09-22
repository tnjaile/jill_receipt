<{if $all_content}>
  <{if $isAdmin}>
    <{$delete_jill_unit_func}>
      <script type="text/javascript">
      $(document).ready(function(){
        $("#jill_unit_sort").sortable({ opacity: 0.6, cursor: "move", update: function() {
          var order = $(this).sortable("serialize");
          $.post("<{$xoops_url}>/modules/jill_receipt/admin/jill_unit_save_sort.php", order + "&op=update_jill_unit_sort", function(theResponse){
            $("#jill_unit_save_msg").html(theResponse);
          });
        }
        });
      });
      </script>
  <{/if}>

  <div id="jill_unit_save_msg"></div>
  <div class="responsive">
    <table class="table table-striped table-hover">
      <thead>
        <tr>

            <th>
              <!--補助單位-->
              <{$smarty.const._MD_JILLRECEIP_UNIT}>
            </th>
            <th>
              <!--單位代碼-->
              <{$smarty.const._MD_JILLRECEIP_UNIT_CODE}>
            </th>
          <{if $isAdmin}>
            <th><{$smarty.const._TAD_FUNCTION}></th>
          <{/if}>
        </tr>
      </thead>

      <tbody id="jill_unit_sort">
        <{foreach from=$all_content item=data}>
          <tr id="tr_<{$data.usn}>">

              <td>
                <!--補助單位-->
                <a href="<{$action}>?usn=<{$data.usn}>"><{$data.unit}></a>
              </td>

              <td>
                <!--單位代碼-->
                <{$data.unit_code}>
              </td>

            <{if $isAdmin}>
              <td>
                <a href="javascript:delete_jill_unit_func(<{$data.usn}>);" class="btn btn-xs btn-danger"><{$smarty.const._TAD_DEL}></a>
                <a href="<{$xoops_url}>/modules/jill_receipt/admin/main.php?op=jill_unit_form&usn=<{$data.usn}>" class="btn btn-xs btn-warning"><{$smarty.const._TAD_EDIT}></a>
                <img src="<{$xoops_url}>/modules/tadtools/treeTable/images/updown_s.png" style="cursor: s-resize;margin:0px 4px;" alt="<{$smarty.const._TAD_SORTABLE}>" title="<{$smarty.const._TAD_SORTABLE}>">
              </td>
            <{/if}>
          </tr>
        <{/foreach}>
      </tbody>
    </table>
  </div>



  <{if $isAdmin}>
    <div class="text-right">
      <a href="<{$xoops_url}>/modules/jill_receipt/admin/main.php?op=jill_unit_form" class="btn btn-info"><{$smarty.const._TAD_ADD}></a>
    </div>
  <{/if}>

  <{$bar}>
<{else}>
  <div class="jumbotron text-center">
    <{if $isAdmin}>
      <a href="<{$xoops_url}>/modules/jill_receipt/admin/main.php?op=jill_unit_form" class="btn btn-info"><{$smarty.const._TAD_ADD}></a>
    <{else}>
      <h3><{$smarty.const._TAD_EMPTY}></h3>
    <{/if}>
  </div>
<{/if}>
