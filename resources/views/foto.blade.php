@include('layout.header')
<style>
    /* .content { */
    /* font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif; */
    /* font-size: 15px; */
    /* } */
</style>

<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid pt-2 pl-3 pr-3">
            <div class="row">
                <div class="col-12 col-lg-6 " style="background-color: white;border-radius: 5px">
                    <p class="pl-3 pr-3 pt-3 text-center" style="color:#013C5E;font-size: 17px">Sampel foto terakhir
                        <span class="font-weight-bold">
                            kualitas
                            baik
                        </span> di
                        conveyor

                    </p>
                    <div class="p-3" style="display: flex;
                    align-items: center;
                    justify-content: center;margin-bottom: 30px">
                        <img src="{{ asset('img/ffb/'.$file[0]) }}" style="border-radius: 5px;
                        max-width: 100%;
                        max-height: 100%;">
                        {{-- <div style="width: 100%;height:200px;" id="empty-image"></div> --}}
                    </div>
                </div>
                <div class="col-12 col-lg-6 " style="background-color: white;border-radius: 5px">
                    <p class="pl-3 pr-3 pt-3 text-center" style="color:#013C5E;font-size: 17px">Sampel foto terakhir
                        <span class="font-weight-bold"> kualitas rendah
                        </span> di
                        conveyor
                    </p>
                    <div class="p-3" style="display: flex;
                    align-items: center;
                    justify-content: center;margin-bottom: 30px">
                        <img src="{{ asset('img/ffb/'.$file[1]) }}" style="border-radius: 5px;
                        max-width: 100%;
                        max-height: 100%;">

                    </div>
                </div>
            </div>
    </section>
</div>
@include('layout.footer')

{{-- <script src="{{ asset('lottie/93121-no-data-preview.json') }}" type="text/javascript"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.9.4/lottie.min.js"
    integrity="sha512-ilxj730331yM7NbrJAICVJcRmPFErDqQhXJcn+PLbkXdE031JJbcK87Wt4VbAK+YY6/67L+N8p7KdzGoaRjsTg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- jQuery -->
<script src="{{ asset('/public/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('/public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('/public/plugins/chart.js/Chart.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/public/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('/public/js/demo.js') }}"></script>

<script src="{{ asset('/public/js/loader.js') }}"></script>



<script>
    var animation = bodymovin.loadAnimation({
    // animationData: { /* ... */ },
    container: document.getElementById('empty-image'), // required
    path: 'https://assets8.lottiefiles.com/private_files/lf30_rrpywigs.json', // required
    renderer: 'svg', // required
    loop: true, // optional
    autoplay: true, // optional
    name: "Demo Animation", // optional
  });

</script>