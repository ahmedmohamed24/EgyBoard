    @csrf
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p class="alert alet-danger my-1">{{ $error }}</p>
        @endforeach 
    @endif
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" value="{{ $project->title }}" class="form-control" placeholder="Project title">
        @error('title')
            <p class="alert alert-danger py-2 text-center">{{ $message }}</p>
        @enderror
    </div> 
    <div class="form-group">
      <label for="description">Description</label>
      <textarea  name="description" id="description" class="form-control" placeholder="project description" >{{ $project->description }}</textarea>
        @error('description')
            <p class="alert alert-danger py-2 text-center">{{ $message }}</p>
        @enderror
    </div>
    <div class="form-group">
      <label for="notes">Notes</label>
      <textarea  name="notes" id="notes" class="form-control" placeholder="here you can add notes about your tasks or you may add them later" >{{ $project->notes }}</textarea>
        @error('notes')
            <p class="alert alert-danger py-2 text-center">{{ $message }}</p>
        @enderror
    </div>
    <div class="form-group">
        <button class="btn btn-primary" type="submit">{{ $buttonText }}</button>
        <a class="btn btn-secondary text-white" href="{{ route('project.all') }}">Cancel</a>
    </div>
</form>