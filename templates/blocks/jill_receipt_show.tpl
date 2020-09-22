<ul class="list-group">
  <{foreach from=$block.content item=data}>
    <li class="list-group-item"><i class="fa fa-check-square-o" aria-hidden="true"></i>
 <{$data.title}><span class="badge"><{$data.uid_name}></span></li>  
  <{/foreach}>
</ul>