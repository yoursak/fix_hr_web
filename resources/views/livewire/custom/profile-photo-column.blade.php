<!-- profile-photo-column.blade.php -->
@if($model->profile_photo)
    <img src="{{ asset('storage/livewire_employee_profile/' . $model->profile_photo) }}" alt="Profile Photo" style="width: 50px; height: 50px;">
@else
    <!-- If no profile photo exists -->
    No Photo Available
@endif
