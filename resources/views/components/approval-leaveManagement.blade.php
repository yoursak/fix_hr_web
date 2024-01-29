<div>
    <div id="p2" class="form-group form-row">
        <form action="{{ route('approval_submit') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="row ">
                    <div class="col-xl-8">
                        <input type="text" name="load" value="2">
                        <h4 class="card-title"><span>Leave Approval </span></h4>
                    </div>

                    <div class="form-group row m-4">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Approval Cycle</label>
                        <div class="col-sm-5">
                            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                <input type="radio" class="btn-check" name="btnradio" id="btnradiomonth" value="1"
                                    checked>
                                <label class="btn btn-outline-primary" for="btnradiomonth">Sequential
                                    {{-- (Chain) --}}
                                </label>
                                <input type="radio" class="btn-check" name="btnradio" id="btnradioyear" value="2">
                                <label class="btn btn-outline-primary" for="btnradioyear">
                                    Parallel {{-- Simultaneous --}}
                                </label>
                            </div>
                        </div>
                    </div>

                </div>

                <hr style="background: black" />
                <h4 class="card-title"><span>Approval Category</span></h4>
                <div class="text-end">

                    <button type="button" class="btn btn-outline-primary add_item_btn"><i class="fe fe-plus bold"></i>
                    </button>
                </div>
                <div class="row ">
                    <span id="show_item">

                    </span>

                </div>

            </div>

            <div class="text-center">
                <button class="btn btn-success" type="submit">Apply</button>
            </div>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</div>