@extends('layouts.customer_panel')
@section('content')
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
              <div class="box-body">
                <div class="row">
                  <div class="col-md-4">
                   <strong class="text-info">{{ trans('message.invoice.thanks')}}</strong>
                  </div>
                </div>
              </div>              
            </div>
        </div>
      </div>
    </section>
@endsection

@section('js')
  <script type="text/javascript">
  </script>
@endsection