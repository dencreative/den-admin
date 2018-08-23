@extends('layouts.app')

@section('body')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('calendar.index')}}" method="POST">
                @csrf
                @method('POST')

                <div class="card-body" style="z-index: 0;">

                    <div class="form-group input-group">
                        <span class="input-group-text">I will be away from</span>
                        <input type="text" class="form-control date-picker" placeholder="Pick a date">
                        <span class="input-group-text"> till </span>
                        <input type="text" id="second-date-picker" class="form-control date-picker" placeholder="Pick a date">
                        {{--<div class="input-group-append">--}}
                            {{--<span id="day-counter" class="input-group-text">XX Days</span>--}}
                        {{--</div>--}}
                    </div>
                    {{--
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">I will be away from</span>
                        </div>
                        <input type="text" class="form-control date-picker" placeholder="Pick a date">
                        <div class="input-group">
                            <span class="input-group-text"> till </span>
                        </div>
                        <input type="text" id="second-date-picker" class="form-control date-picker" placeholder="Pick a date">
                        <div class="input-group-append">
                            <span id="day-counter" class="input-group-text">XX Days</span>
                        </div>
                    </div>
--}}
                    <div class="form-group">
                        <label>Reason</label>
                        <input type="text" class="form-control" placeholder="I want a holiday..?">
                        <i class="form-group__bar"></i>
                    </div>

                    <button type="submit" class="btn btn-primary playbook-button">Request</button>
                    <a href="/holidays">
                        <button type="button" class="btn btn-light playbook-button">Cancel</button>
                    </a>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('js')
    //FIXME: Add this another cleaner way
    <script src="https://unpkg.com/flatpickr@4.4.4/dist/plugins/rangePlugin.js"></script>
    <script>
        $(document).ready(function() {
            $(".date-picker").flatpickr({
                mode: "range",
                altInput: true,
                altFormat: "F j, Y",
                minDate: 'today',
                locale: {
                    firstDayOfWeek: 1
                },
                onClose: function(selectedDates) {
                    console.log();
                    document.getElementById("day-counter").innerHTML = daysBetween(selectedDates[0], selectedDates[1]) +" days";
                },
                plugins: [
                    new rangePlugin({ input: "#second-date-picker"})
                ]

            });

        });

        function daysBetween( date1, date2 ) {
            const one_day = 1000 * 60 * 60 * 24;
            var difference = date1.getTime() - date2.getTime();
            return Math.round(difference / one_day);
        }
    </script>
@endsection


