@if($errors->any())
<?
    $type=NULL;
    $title=NULL;
    $msg=NULL;
?>
<div class="alert-container">
    @foreach($errors->all() as $k=>$e)
        <?
        if($k==0) $type=$e;
        if($k==1) $title=$e;
        if($k==2) $msg=$e;
        ?>
    @endforeach
    <div class="alert alert-{{$type}}" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong class="alert-heading">{{$title}}</strong>
        <hr>
        <p class="mb-0">{{$msg}}</p>
    </div>
</div>
@endif