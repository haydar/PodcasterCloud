@extends('custom.layouts.master')
@section('content')
<div class="row justify-content-center align-items-center mx-auto h-100">
        <div class="col-md-6 text-center my-2">
            <a href="{{route('podcast.create')}}" class="btn btn-primary">Create a new Podcast</a>
        </div>
        @isset($podcasts)
        <table class="table col-md-8 bg-white">
            <thead>
                <tr>
                    <th>Podcast Name</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($podcasts as $podcast)
                <tr>
                    <td class="col-md-6">{{ $podcast->name }}</td>
                    <td class="col-md-3">
                        <div>
                            <a href="{{ route('podcast.show', $podcast->slug) }}" class="btn btn-success btn-md">Manage Podcast</a>
                        </div>
                    </td>
                    <td class="col-md-3">
                        <form role="form" method="POST" id="deletePodcast" action="{{route('podcast.destroy',$podcast->id)}}">
                            <button type="submit" class="btn btn-danger">Sil</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endisset
</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.28.5/sweetalert2.all.js" integrity="sha256-+yrurPEYDIh9PES+m128Vc0a49Csb6lx0lSzXjX62HQ=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $(document).on('submit','#deletePodcast', function(e){
            var line=$(this).closest('tr');
            console.log(line);
            e.preventDefault();
            swal({
                    title: 'Are you sure you want delete?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                         $.ajax({
                            url:$(this).attr("action"),
                            type:'DELETE',
                            headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },

                            success:function(result){
                                swal(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                                );
                                line.fadeOut(1000);
                            }
                        });


                    }
                })
        });
    });
</script>
@endsection
