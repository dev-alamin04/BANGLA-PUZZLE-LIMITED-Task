<div class="text-center">
    <div class="btn-group btn-group-sm" role="group">
        <a href="{{ route('admin.cms_contents.show', $row->id) }}" class="btn btn-info" title="View Details">
            <i class="fas fa-eye"></i>
        </a>
        <a href="{{ route('admin.cms_contents.edit', $row->id) }}" class="btn btn-warning" title="Edit">
            <i class="fas fa-edit"></i>
        </a>
        <a href="#" class="text-white btn btn-danger deletebtn" title="Delete" data-id="{{ $row->id }}">
            <i class="fas fa-trash-alt"></i>
        </a>
    </div>
</div>