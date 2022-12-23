@extends('layouts.customer_panel')
@section('content')
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
        <?php $lastCName = ''; ?>
        @foreach ($itemData as $data)
            <?php
                $newCname = $data->category_name; 
                if($lastCName != $newCname){
                    echo $lastCName =='' ? '':'</div><div class="col-lg-12">';
                    echo  '<h1>'.$newCname.'</h1><hr />'; 
                    $lastCName = $newCname;
                }
                 
            ?>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ $data->purchase_price }}</h3>
                    <p>{{ $data->description }}</p>
                </div>
                <div class="icon">
                    @if (!empty($data->img))
                    <img src='{{url("public/uploads/itemPic/$data->img")}}' alt="" width="50" height="50">
                    @else
                    <img src='{{url("public/uploads/default-image.png")}}' alt="" width="50" height="50">
                    @endif
                </div>                
                <a class="small-box-footer" data-target-url="{{ route('customer.order.cart', ['id' => $data->item_id ]) }}" href="javascript:;" data-toggle="modal" data-target-id="" data-target="#myModal" title="Edit Image Info">Add To Cart <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        @endforeach
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script type="text/javascript">
    $(document).ready(function(){
        $.ajaxSetup({
           headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        });

        $("#myModal").on("show.bs.modal", function(e) {
            url =  $(e.relatedTarget).data('target-url');
            $.get( url , function( data ) {
                $(".modal-body").html(data);
            });

        });
    });
</script>
@endsection