@extends('layouts.app')
@section('content')
    <?php $no_search = true; ?>

    @include('includes.search')
    <button class="btn btn-primary" onclick="ExportToExcel('xlsx')">Export to excel</button>

    <div class="table table-responsive" style ="text-align: left" id="report_sheet">
        <table class="table">
            <tr>
                <th>{{__('Application date')}}</th>
                <th>{{__('Image')}}</th>
                <th>{{__('Card')}}</th>
                <th>{{__('Card number')}}</th>
                <th>{{__('Customer')}}</th>
                <th>{{__('Benefit')}}</th>
                <th>{{__('Restriction')}}</th>
            </tr>

            @foreach($applications as $application)
                <tr>
                    <td>{{$application->created_at}}</td>
                    <td>
                        <?php $the_image = $application->getAssignment()->getCard()->getImage() ?>
                        @if(!empty($the_image))
                            <img width="100px" src="<?php echo  '/images/system/' . $the_image->id . '.' . $the_image->extension ?>" alt="{{$the_image->name}}">
                        @endif
                    </td>
                    <td>
                        {{ $application->getAssignment()->getCard()->name}}
                    </td>
                    <td>
                        {{$application->getAssignment()->number}}
                    </td>
                    <td>
                        {{$application->getAssignment()->email}}
                    </td>

                    <td>
                        {{$application->getBenefit()->benefit}}
                    </td>

                    <td>
                        {{$application->getBenefit()->restriction}}
                    </td>

                </tr>
            @endforeach

        </table>
    </div>
    <div style="width: 100%;">
        {{ $applications->links() }}
    </div>

    <div id="elementH"></div>

@endsection

@section('new_scripts')
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
@endsection


