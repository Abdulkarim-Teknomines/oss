
// $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
//         $(document).ready(function () {
//             /*------------------------------------------
//             Country Dropdown Change Event
//             --------------------------------------------*/
//             $('#country').on('change', function () {
//                 var idCountry = this.value;
//                 $("#state").html('');
//                 $.ajax({
//                     url: "{{route('states')}}",
//                     type: "POST",
//                     data: {
//                         country_id: idCountry,
//                         _token: '{{csrf_token()}}'
//                     },
//                     dataType: 'json',
//                     success: function (result) {
//                         $('#state').html('<option value="">-- Select State --</option>');
//                         $.each(result.states, function (key, value) {
//                             $("#state").append('<option value="' + value.id + '">' + value.name + '</option>');
//                         });
//                         $('#city').html('<option value="">-- Select City --</option>');
//                     }
//                 });
//             });
//             /*------------------------------------------
//             State Dropdown Change Event
//             --------------------------------------------*/
//             $('#state').on('change', function () {
//                 var idState = this.value;
//                 $("#city").html('');

//                 $.ajax({
//                     url: "{{route('cities')}}",
//                     type: "POST",
//                     data: {
//                         state_id: idState,
//                         _token: '{{csrf_token()}}'

//                     },
//                     dataType: 'json',
//                     success: function (res) {
//                         $('#city').html('<option value="">-- Select City --</option>');
//                         $.each(res.cities, function (key, value) {
//                             $("#city").append('<option value="' + value.id + '">' + value.name + '</option>');
//                         });
//                     }
//                 });
//             });
//         });

    