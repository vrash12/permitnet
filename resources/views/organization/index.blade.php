@extends('layouts.app')

@section('page-title', 'Organization')

@section('content')
<style>
    .org-page-header {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-bottom: 18px;
    }

    .org-main-btn {
        height: 38px;
        padding: 0 16px;
        border: 0;
        border-radius: 8px;
        background: #1293ee;
        color: #ffffff;
        font-family: 'Work Sans', Arial, sans-serif;
        font-weight: 800;
        cursor: pointer;
        box-shadow: 0 3px 7px rgba(0,0,0,0.18);
    }

    .org-main-btn:hover {
        background: #0878c8;
    }

    .org-main-btn.secondary {
        background: #ffffff;
        color: #1293ee;
        border: 1px solid #1293ee;
    }

    .success-alert {
        background: #dcfce7;
        color: #15803d;
        padding: 12px 14px;
        border-radius: 8px;
        font-weight: 700;
        margin-bottom: 14px;
    }

    .error-alert {
        background: #fee2e2;
        color: #b91c1c;
        padding: 12px 14px;
        border-radius: 8px;
        font-weight: 700;
        margin-bottom: 14px;
    }

    .org-card-wrap {
        position: relative;
        display: inline-flex;
        flex-direction: column;
        align-items: center;
        gap: 7px;
        z-index: 3;
    }

    .org-mini-actions {
        display: flex;
        gap: 6px;
    }

    .org-mini-btn {
        border: 0;
        border-radius: 6px;
        padding: 5px 8px;
        font-size: 10px;
        font-weight: 800;
        cursor: pointer;
        font-family: 'Work Sans', Arial, sans-serif;
    }

    .org-mini-btn.update {
        background: #1293ee;
        color: white;
    }

    .org-mini-btn.delete {
        background: #ef4444;
        color: white;
    }

    .modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        padding: 20px;
    }

    .modal-backdrop.show {
        display: flex;
    }

    .modal-box {
        width: 100%;
        max-width: 560px;
        max-height: 90vh;
        overflow-y: auto;
        background: #ffffff;
        border-radius: 18px;
        box-shadow: 0 25px 70px rgba(0,0,0,0.32);
        animation: modalPop 0.18s ease-out;
    }

    .modal-box.small {
        max-width: 430px;
    }

    @keyframes modalPop {
        from {
            transform: translateY(12px) scale(0.98);
            opacity: 0;
        }

        to {
            transform: translateY(0) scale(1);
            opacity: 1;
        }
    }

    .modal-header {
        padding: 20px 22px;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-title {
        font-size: 22px;
        font-weight: 800;
    }

    .modal-close {
        width: 34px;
        height: 34px;
        border: 0;
        border-radius: 50%;
        background: #eff6ff;
        color: #1293ee;
        font-size: 24px;
        line-height: 1;
        cursor: pointer;
    }

    .modal-body {
        padding: 22px;
    }

    .modal-form {
        display: grid;
        gap: 13px;
    }

    .modal-form label {
        font-size: 13px;
        font-weight: 800;
        margin-bottom: -6px;
    }

    .modal-form input,
    .modal-form select {
        width: 100%;
        height: 44px;
        border: 1px solid #d1d5db;
        border-radius: 9px;
        padding: 0 12px;
        font-family: 'Work Sans', Arial, sans-serif;
        font-size: 14px;
        outline: none;
    }

    .modal-form input:focus,
    .modal-form select:focus {
        border-color: #1293ee;
        box-shadow: 0 0 0 3px rgba(18, 147, 238, 0.15);
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding-top: 8px;
    }

    .modal-submit {
        height: 42px;
        padding: 0 18px;
        border: 0;
        border-radius: 8px;
        background: #1293ee;
        color: white;
        font-weight: 800;
        cursor: pointer;
        font-family: 'Work Sans', Arial, sans-serif;
    }

    .modal-submit:hover {
        background: #0878c8;
    }

    .modal-cancel {
        height: 42px;
        padding: 0 18px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background: white;
        color: #374151;
        font-weight: 800;
        cursor: pointer;
        font-family: 'Work Sans', Arial, sans-serif;
    }

    .modal-danger {
        height: 42px;
        padding: 0 18px;
        border: 0;
        border-radius: 8px;
        background: #ef4444;
        color: white;
        font-weight: 800;
        cursor: pointer;
        font-family: 'Work Sans', Arial, sans-serif;
    }

    .manage-list {
        display: grid;
        gap: 12px;
    }

    .manage-item {
        border: 1px solid #e5e7eb;
        background: #f9fbff;
        border-radius: 12px;
        padding: 14px;
        display: flex;
        justify-content: space-between;
        gap: 14px;
        align-items: center;
    }

    .manage-name {
        font-weight: 800;
        font-size: 15px;
    }

    .manage-meta {
        font-size: 12px;
        color: #64748b;
        margin-top: 4px;
    }

    .manage-actions {
        display: flex;
        gap: 8px;
        flex-shrink: 0;
    }

    .manage-btn {
        height: 34px;
        padding: 0 12px;
        border: 0;
        border-radius: 7px;
        font-weight: 800;
        cursor: pointer;
        font-family: 'Work Sans', Arial, sans-serif;
    }

    .manage-btn.view {
        background: #e0f2fe;
        color: #0878c8;
    }

    .manage-btn.update {
        background: #1293ee;
        color: white;
    }

    .manage-btn.delete {
        background: #fee2e2;
        color: #dc2626;
    }

    .delete-warning {
        font-size: 15px;
        line-height: 1.6;
        color: #374151;
        margin-bottom: 16px;
    }

    .delete-member-name {
        font-weight: 800;
        color: #111827;
    }

    @media (max-width: 720px) {
        .org-page-header {
            justify-content: stretch;
            flex-direction: column;
        }

        .org-main-btn {
            width: 100%;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .manage-item {
            flex-direction: column;
            align-items: stretch;
        }

        .manage-actions {
            flex-wrap: wrap;
        }

        .manage-btn {
            flex: 1;
        }
    }
</style>

@if(session('success'))
    <div class="success-alert">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="error-alert">
        {{ $errors->first() }}
    </div>
@endif

<div class="org-page-header">
    <button type="button" class="org-main-btn" onclick="openModal('createMemberModal')">
        + Create Member
    </button>

    <button type="button" class="org-main-btn secondary" onclick="openModal('manageMembersModal')">
        Manage Members
    </button>
</div>

<div class="org-panel">
    <div class="org-chart">
        <div class="org-lines">
            <div class="line ceo-down"></div>
            <div class="line admin-horizontal"></div>
            <div class="line left-admin-down"></div>
            <div class="line right-admin-down"></div>
            <div class="line staff-horizontal"></div>
            <div class="line staff-left"></div>
            <div class="line staff-middle"></div>
            <div class="line staff-right"></div>
        </div>

        @if($ceo)
            <div class="org-level">
                <div class="org-card-wrap">
                    <a href="{{ route('organization.show', ['member' => $ceo->id]) }}" class="org-card">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 2c-2.5 0-4.5 2.2-4.5 5c0 2.7 2 5 4.5 5s4.5-2.3 4.5-5c0-2.8-2-5-4.5-5zm-7 20c.4-4.8 3.2-8 7-8s6.6 3.2 7 8H5zm7-7l-2 2l2 4l2-4l-2-2z"/>
                        </svg>

                        <div class="org-name">{{ $ceo->name }}</div>
                        <div class="org-position">{{ $ceo->position }}</div>
                    </a>

                    <div class="org-mini-actions">
                        <button type="button" class="org-mini-btn update" onclick="openModal('updateMemberModal{{ $ceo->id }}')">
                            Update
                        </button>

                        <button type="button" class="org-mini-btn delete" onclick="openModal('deleteMemberModal{{ $ceo->id }}')">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        @else
            <div class="empty-state">
                No organization members found. Click Create Member to add one.
            </div>
        @endif

        <div class="org-level admin-level">
            @foreach($admins as $admin)
                <div class="org-card-wrap">
                    <a href="{{ route('organization.show', ['member' => $admin->id]) }}" class="org-card">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 2c-2.5 0-4.5 2.2-4.5 5c0 2.7 2 5 4.5 5s4.5-2.3 4.5-5c0-2.8-2-5-4.5-5zm-7 20c.4-4.8 3.2-8 7-8s6.6 3.2 7 8H5zm7-7l-2 2l2 4l2-4l-2-2z"/>
                        </svg>

                        <div class="org-name">{{ $admin->name }}</div>
                        <div class="org-position">{{ $admin->position }}</div>
                    </a>

                    <div class="org-mini-actions">
                        <button type="button" class="org-mini-btn update" onclick="openModal('updateMemberModal{{ $admin->id }}')">
                            Update
                        </button>

                        <button type="button" class="org-mini-btn delete" onclick="openModal('deleteMemberModal{{ $admin->id }}')">
                            Delete
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="org-level staff-level">
            @foreach($staff as $person)
                <div class="org-card-wrap">
                    <a href="{{ route('organization.show', ['member' => $person->id]) }}" class="org-card">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 2c-2.5 0-4.5 2.2-4.5 5c0 2.7 2 5 4.5 5s4.5-2.3 4.5-5c0-2.8-2-5-4.5-5zm-7 20c.4-4.8 3.2-8 7-8s6.6 3.2 7 8H5zm7-7l-2 2l2 4l2-4l-2-2z"/>
                        </svg>

                        <div class="org-name">{{ $person->name }}</div>
                        <div class="org-position">{{ $person->position }}</div>
                    </a>

                    <div class="org-mini-actions">
                        <button type="button" class="org-mini-btn update" onclick="openModal('updateMemberModal{{ $person->id }}')">
                            Update
                        </button>

                        <button type="button" class="org-mini-btn delete" onclick="openModal('deleteMemberModal{{ $person->id }}')">
                            Delete
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- CREATE MODAL --}}
<div class="modal-backdrop" id="createMemberModal">
    <div class="modal-box">
        <div class="modal-header">
            <div class="modal-title">Create Member</div>
            <button type="button" class="modal-close" onclick="closeModal('createMemberModal')">&times;</button>
        </div>

        <div class="modal-body">
            <form method="POST" action="{{ route('organization.store') }}" class="modal-form">
                @csrf

                <label>Full Name</label>
                <input type="text" name="name" placeholder="Full Name" required>

                <div class="form-row">
                    <div>
                        <label>Position</label>
                        <input type="text" name="position" placeholder="CEO, Admin, Staff" required>
                    </div>

                    <div>
                        <label>Sort Order</label>
                        <input type="number" name="sort_order" value="0">
                    </div>
                </div>

                <label>Contact</label>
                <input type="text" name="contact" placeholder="Contact Number">

                <label>Street</label>
                <input type="text" name="street" placeholder="Street">

                <label>City</label>
                <input type="text" name="city" placeholder="City">

                <label>Parent Member</label>
                <select name="parent_id">
                    <option value="">No Parent / Top Level</option>
                    @foreach($members as $parent)
                        <option value="{{ $parent->id }}">
                            {{ $parent->name }} - {{ $parent->position }}
                        </option>
                    @endforeach
                </select>

                <div class="modal-footer">
                    <button type="button" class="modal-cancel" onclick="closeModal('createMemberModal')">
                        Cancel
                    </button>

                    <button type="submit" class="modal-submit">
                        Create Member
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MANAGE MEMBERS MODAL --}}
<div class="modal-backdrop" id="manageMembersModal">
    <div class="modal-box">
        <div class="modal-header">
            <div class="modal-title">Manage Members</div>
            <button type="button" class="modal-close" onclick="closeModal('manageMembersModal')">&times;</button>
        </div>

        <div class="modal-body">
            <div class="manage-list">
                @forelse($members as $item)
                    <div class="manage-item">
                        <div>
                            <div class="manage-name">{{ $item->name }}</div>
                            <div class="manage-meta">
                                {{ $item->position }}
                                @if($item->parent)
                                    • Reports to {{ $item->parent->name }}
                                @else
                                    • Top Level
                                @endif
                            </div>
                        </div>

                        <div class="manage-actions">
                            <a href="{{ route('organization.show', ['member' => $item->id]) }}" class="manage-btn view">
                                View
                            </a>

                            <button type="button" class="manage-btn update" onclick="closeModal('manageMembersModal'); openModal('updateMemberModal{{ $item->id }}')">
                                Update
                            </button>

                            <button type="button" class="manage-btn delete" onclick="closeModal('manageMembersModal'); openModal('deleteMemberModal{{ $item->id }}')">
                                Delete
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        No members yet.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- UPDATE AND DELETE MODALS --}}
@foreach($members as $item)
    <div class="modal-backdrop" id="updateMemberModal{{ $item->id }}">
        <div class="modal-box">
            <div class="modal-header">
                <div class="modal-title">Update Member</div>
                <button type="button" class="modal-close" onclick="closeModal('updateMemberModal{{ $item->id }}')">&times;</button>
            </div>

            <div class="modal-body">
                <form method="POST" action="{{ route('organization.update', ['member' => $item->id]) }}" class="modal-form">
                    @csrf
                    @method('PUT')

                    <label>Full Name</label>
                    <input type="text" name="name" value="{{ $item->name }}" required>

                    <div class="form-row">
                        <div>
                            <label>Position</label>
                            <input type="text" name="position" value="{{ $item->position }}" required>
                        </div>

                        <div>
                            <label>Sort Order</label>
                            <input type="number" name="sort_order" value="{{ $item->sort_order }}">
                        </div>
                    </div>

                    <label>Contact</label>
                    <input type="text" name="contact" value="{{ $item->contact }}">

                    <label>Street</label>
                    <input type="text" name="street" value="{{ $item->street }}">

                    <label>City</label>
                    <input type="text" name="city" value="{{ $item->city }}">

                    <label>Parent Member</label>
                    <select name="parent_id">
                        <option value="">No Parent / Top Level</option>

                        @foreach($members as $parent)
                            @if($parent->id !== $item->id)
                                <option value="{{ $parent->id }}" {{ $item->parent_id == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->name }} - {{ $parent->position }}
                                </option>
                            @endif
                        @endforeach
                    </select>

                    <div class="modal-footer">
                        <button type="button" class="modal-cancel" onclick="closeModal('updateMemberModal{{ $item->id }}')">
                            Cancel
                        </button>

                        <button type="submit" class="modal-submit">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal-backdrop" id="deleteMemberModal{{ $item->id }}">
        <div class="modal-box small">
            <div class="modal-header">
                <div class="modal-title">Delete Member</div>
                <button type="button" class="modal-close" onclick="closeModal('deleteMemberModal{{ $item->id }}')">&times;</button>
            </div>

            <div class="modal-body">
                <div class="delete-warning">
                    Are you sure you want to delete
                    <span class="delete-member-name">{{ $item->name }}</span>?
                    This action cannot be undone.
                </div>

                <form method="POST" action="{{ route('organization.destroy', ['member' => $item->id]) }}">
                    @csrf
                    @method('DELETE')

                    <div class="modal-footer">
                        <button type="button" class="modal-cancel" onclick="closeModal('deleteMemberModal{{ $item->id }}')">
                            Cancel
                        </button>

                        <button type="submit" class="modal-danger">
                            Delete Member
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<script>
    function openModal(id) {
        const modal = document.getElementById(id);

        if (modal) {
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeModal(id) {
        const modal = document.getElementById(id);

        if (modal) {
            modal.classList.remove('show');
            document.body.style.overflow = '';
        }
    }

    document.addEventListener('click', function (event) {
        if (event.target.classList.contains('modal-backdrop')) {
            event.target.classList.remove('show');
            document.body.style.overflow = '';
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            document.querySelectorAll('.modal-backdrop.show').forEach(function (modal) {
                modal.classList.remove('show');
            });

            document.body.style.overflow = '';
        }
    });
</script>
@endsection