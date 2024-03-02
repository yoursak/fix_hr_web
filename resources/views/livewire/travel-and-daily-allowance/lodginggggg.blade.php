<div class="col-12">
     {{-- Include jQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <div class="form-group">
        <label class="form-label">Grade Name</label>
        <select name="grade_id" id="leave_category5" class="form-control" placeholder="Category Name" required>
            @foreach ($grade_list as $list)
                <option value="{{ $list->id }}" {{ $list->id == '${gradeName}'  ? 'selected' : '' }} >{{ $list->grade_name }}</option>
            @endforeach
        </select>

    </div>
    <input type="hidden" name="edit" value="">
    <div class="form-group">
        <label for="travel_type" class="form-label">Travel Type</label>
        <select class="form-control" id="travel_type" name="travel_type" onchange="change_modes(this)" required>
            @foreach ($travel_modes as $mode)
                <option value="{{ $mode->travel_m_id }}" {{ $mode->travel_m_id == '${travelType}' ? 'selected' : '' }}>{{ $mode->travel_class }}</option>
            @endforeach
            <!-- Add more options as needed -->
        </select>
    </div>
    <div class="form-group">
        <label class="form-label">Travel Category</label>
        <input type="text" name="travel_category" id="travel_all" class="form-control" placeholder="Enter Travel Category" value="${travelCategory}" required>
    </div>

    <div class="form-group">
        <label class="form-label">Lodging Type</label>
        <input type="text" name="lodging_type" id="lodging_type" class="form-control" placeholder="Enter Lodging Type" value="${lodgingType}" required>
    </div>
    <div class="form-group">
        <label class="form-label">Lodging Amount</label>
        <input type="number" name="lodging_amount" id="lodging_amount" class="form-control" placeholder="Enter Lodging Amount" value="${lodgingAmount}" required>
    </div>

    <p class="mb-0 pb-0 text-muted fs-12 mt-5">By continuing you agree to <a href="#" class="text-primary">Terms & Conditions</a></p>
</div>
