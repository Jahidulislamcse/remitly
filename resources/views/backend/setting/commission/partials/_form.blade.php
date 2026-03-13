<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Type <span class="text-danger">*</span></label>
        <select name="type" class="form-control" required>
            <option value="" disabled {{ old('type', $commition->type) ? '' : 'selected' }}>Please select</option>
            <option value="Mobile pay" {{ old('type', $commition->type) == 'Mobile pay' ? 'selected' : '' }}>Mobile pay</option>
            <option value="Bank Add pay" {{ old('type', $commition->type) == 'Bank Add pay' ? 'selected' : '' }}>Bank Add pay</option>
        </select>
        @error('type')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>



    <div class="col-md-6">
        <label class="form-label">Percentage (%) <span class="text-danger">*</span></label>
        <input type="number" name="percentage" step="0.01" min="0" max="100"
            class="form-control" value="{{ old('percentage', $commition->percentage) }}" required>
        @error('percentage') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="col-12 d-flex gap-2 mt-2">
        <button type="submit" class="btn btn-success">{{ $button ?? 'Save' }}</button>
        <a href="{{ route('admin.commission.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>