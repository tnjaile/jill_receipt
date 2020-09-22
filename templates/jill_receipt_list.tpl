<{if $can_receipt}>
  <{includeq file="$xoops_rootpath/modules/jill_receipt/templates/jill_receipt_personlist.tpl"}>
<{else}>
  <div class="jumbotron text-center">
    <h3><{$smarty.const._MD_JILLRECEIP_GROUPERROR}></h3>
  </div>  
<{/if}>
