<ul class="action-button-list">
    <li>
        @if ($dataijin->status == 'i')
            <a href="/ijinabsen/{{ $dataijin->kode_ijin }}/edit" class="btn btn-list text-primary">
                <span>
                    <ion-icon name="create-outline"></ion-icon>
                    Ubah
                </span>
            </a>
        @elseif ($dataijin->status == 's')
            <a href="/ijinsakit/{{ $dataijin->kode_ijin }}/edit" class="btn btn-list text-primary">
                <span>
                    <ion-icon name="create-outline"></ion-icon>
                    Ubah
                </span>
            </a>
        @elseif ($dataijin->status == 'c')
            <a href="/ijincuti/{{ $dataijin->kode_ijin }}/edit" class="btn btn-list text-primary">
                <span>
                    <ion-icon name="create-outline"></ion-icon>
                    Ubah
                </span>
            </a>
        @endif

    </li>
    <li>
        <a href="#" id="deletebutton" class="btn btn-list text-danger" data-dismiss="modal" data-toggle="modal"
            data-target="#deleteConfirm">
            <span>
                <ion-icon name="trash-outline"></ion-icon>
                Hapus
            </span>
        </a>
    </li>
</ul>

<script>
    $(function() {
        $("#deletebutton").click(function(e) {
            $("#hapuspengajuan").attr('href', '/dataijin/' + '{{ $dataijin->kode_ijin }}/delete');
        });
    });
</script>
