<div id="notifications" class="row no-print">
    <div class="col-md-12">
        @if($errors->any())
        <div class="noti-alert pad no-print">
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif
        @if(session('success'))
        <div class="noti-alert pad no-print">
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                <ul>
                    <li>{{ session('success') }}</li>
                </ul>
            </div>
        </div>
        @endif

        @if(session('fail'))
        <div class="noti-alert pad no-print">
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                <h4><i class="icon fa fa-check"></i> Operation Fail</h4>
                <ul>
                    <li>{{ session('fail') }}</li>
                </ul>
            </div>
        </div>
        @endif
    </div>
</div>

