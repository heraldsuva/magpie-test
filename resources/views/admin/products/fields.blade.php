<!-- Name Field -->
<div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input type="text" class="form-control" name="name" id="name" value="{{old('name', $product->name)}}">

    @error('name')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="price" class="form-label">Price</label>
    <input type="text" class="form-control" name="price" id="price" value="{{old('name', $product->price)}}">
    @error('price')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <input type="text" class="form-control" name="description" id="description" value="{{old('name', $product->description)}}">
    @error('description')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="stock" class="form-label">Stock</label>
    <input type="text" class="form-control" name="stock" id="stock" value="{{old('name', $product->stock)}}">
    @error('stock')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

{{-- <div class="mb-3">
    <label for="image" class="form-label">Image</label>
    <input type="file" class="form-control" name="image" id="image">
</div> --}}