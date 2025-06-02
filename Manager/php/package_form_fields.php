<div class="col-md-6">
    <label for="name" class="form-label">Package Name</label>
    <input type="text" class="form-control" name="name" required>
</div>
<div class="col-md-6">
    <label for="type" class="form-label">Type</label>
    <select class="form-select" name="type" required>
        <option value="">-- Select Type --</option>
        <option value="Airplane Trip with Guide">Airplane Trip with Guide</option>
        <option value="All-Inclusive">All-Inclusive</option>
        <option value="Individual Package">Individual Package</option>
    </select>
</div>

<div class="col-md-6">
    <label for="date" class="form-label">Start Date</label>
    <input type="date" class="form-control" name="date" required>
</div>
<div class="col-md-6">
    <label for="end_date" class="form-label">End Date</label>
    <input type="date" class="form-control" name="end-date" required>
</div>
<div class="col-md-6">
    <label for="price" class="form-label">Price</label>
    <input type="number" class="form-control" name="price" required>
</div>
<div class="col-md-6">
    <label for="place" class="form-label">Place</label>
    <input type="text" class="form-control" name="place" required>
</div>
<div class="col-md-6">
    <label for="available_spots" class="form-label">Available Spots</label>
    <input type="number" class="form-control" name="available_spots" required>
</div>
<div class="col-md-12">
    <label for="image_file" class="form-label">Upload Image</label>
    <input type="file" class="form-control" name="image_file" accept="image/*">
    <input type="hidden" name="image_path" value="">
</div>

<div class="col-md-12">
    <label for="description" class="form-label">Description</label>
    <textarea class="form-control" name="description" rows="3" required></textarea>
</div>
