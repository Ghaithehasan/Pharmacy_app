<!-- Sidebar-right-->
		<div class="sidebar sidebar-left sidebar-animate">
			<div class="panel panel-primary card mb-0 box-shadow">
				<div class="tab-menu-heading border-0 p-3">
					<div class="card-title mb-0">الأشعارات</div>
					<div class="card-options mr-auto">
						<a href="#" class="sidebar-remove"><i class="fe fe-x"></i></a>
					</div>
				</div>
				<div class="panel-body tabs-menu-body latest-tasks p-0 border-0">
					<div class="tabs-menu">
						<!-- Tabs -->
						<ul class="nav panel-tabs">
							<li class=""><a href="#side1" class="active" data-toggle="tab">
								<i class="ion ion-md-chatboxes tx-18 ml-2"></i> محادثة صيدلاني
							</a></li>
							<li><a href="#side2" data-toggle="tab">
								<i class="ion ion-md-notifications tx-18 ml-2"></i> الاشعارات
								@if($supplier->notifications()->where('is_read', false)->count() > 0)
									<span class="badge badge-pill badge-danger ml-2">{{ $supplier->notifications()->where('is_read', false)->count() }}</span>
								@endif
							</a></li>
						</ul>
					</div>
					<div class="tab-content">
						<div class="tab-pane active" id="side1">
							<div class="chat-list-wrapper">
								<div class="chat-search-wrapper">
									<input type="text" class="form-control" placeholder="بحث في المحادثات...">
									<i class="fe fe-search search-icon"></i>
								</div>
								<div class="chat-list">
									<div class="list d-flex align-items-center border-bottom p-3 hover-effect">
										<div class="avatar-wrapper">
											<span class="avatar bg-primary brround avatar-md">CH</span>
											<span class="status-dot bg-success"></span>
										</div>
										<a class="wrapper w-100 mr-3" href="#">
											<div class="d-flex justify-content-between align-items-center mb-1">
												<h6 class="mb-0 font-weight-semibold">New Websites is Created</h6>
												<small class="text-muted">30 mins</small>
											</div>
											<p class="mb-0 text-muted text-truncate">Latest updates on the new website...</p>
										</a>
									</div>
									<!-- Repeat similar structure for other chat items -->
								</div>
							</div>
						</div>
						<div class="tab-pane" id="side2">
							<div class="notifications-wrapper">
								<div class="notifications-header p-3 border-bottom">
									<div class="d-flex justify-content-between align-items-center">
										<h6 class="mb-0">الإشعارات الجديدة</h6>
										@if($supplier->notifications()->where('is_read', false)->count() > 0)
											<form action="{{ route('supplier.notifications.mark-all-as-read') }}" method="POST" class="d-inline mark-all-form">
												@csrf
												<button type="submit" class="btn btn-sm btn-light">تعليم الكل كمقروء</button>
											</form>
										@endif
									</div>
								</div>
								<div class="notifications-list">
									@php
										$unreadNotifications = $supplier->notifications()
											->where('is_read', false)
											->latest()
											->take(5)
											->get();
										
										$recentReadNotifications = $supplier->notifications()
											->where('is_read', true)
											->latest()
											->take(3)
											->get();
									@endphp

									@if($unreadNotifications->count() > 0)
										@foreach($unreadNotifications as $notification)
											<div class="list-group-item d-flex align-items-center notification-item unread">
												<div class="notification-icon bg-primary">
													<i class="fe fe-bell"></i>
												</div>
												<div class="notification-content">
													<div class="d-flex justify-content-between align-items-center">
														<h6 class="mb-1">{{ $notification->notification_type }}</h6>
														<small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
													</div>
													<p class="mb-0 text-muted">{{ $notification->message }}</p>
													<form action="{{ route('supplier.notifications.mark-as-read', $notification->id) }}" method="POST" class="mt-2 mark-read-form">
														@csrf
														<button type="submit" class="btn btn-sm btn-light">تعليم كمقروء</button>
													</form>
												</div>
											</div>
										@endforeach
									@endif

									@if($recentReadNotifications->count() > 0)
										@if($unreadNotifications->count() > 0)
											<div class="p-3 text-muted" style="background: #f8f9fa; font-size: 0.9rem;">
												آخر الإشعارات المقروءة
											</div>
										@endif
										@foreach($recentReadNotifications as $notification)
											<div class="list-group-item d-flex align-items-center notification-item">
												<div class="notification-icon bg-success">
													<i class="fe fe-check-circle"></i>
												</div>
												<div class="notification-content">
													<div class="d-flex justify-content-between align-items-center">
														<h6 class="mb-1">{{ $notification->notification_type }}</h6>
														<small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
													</div>
													<p class="mb-0 text-muted">{{ $notification->message }}</p>
												</div>
											</div>
										@endforeach
									@endif

									@if($unreadNotifications->count() == 0 && $recentReadNotifications->count() == 0)
										<div class="text-center p-5">
											<div class="empty-state-icon mb-3">
												<i class="fe fe-bell-slash"></i>
											</div>
											<p class="text-muted mb-0">لا توجد إشعارات</p>
										</div>
									@endif
								</div>
								<div class="notifications-footer p-3 border-top text-center">
									<a href="{{ route('supplier.notifications.index') }}" class="btn btn-primary btn-block">عرض جميع الإشعارات</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<!--/Sidebar-right-->

<style>
/* Modern Sidebar Styles */
.sidebar {
	width: 320px;
	background: #fff;
}

/* Tab Styles */
.panel-tabs {
	background: #f8f9fa;
	padding: 0.5rem;
	border-radius: 8px;
	margin: 0.5rem;
}

.panel-tabs .nav-link {
	border-radius: 6px;
	padding: 0.5rem 1rem;
	color: #6c757d;
	transition: all 0.3s ease;
}

.panel-tabs .nav-link.active {
	background: #fff;
	color: #3498db;
	box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

/* Chat List Styles */
.chat-search-wrapper {
	position: relative;
	padding: 1rem;
}

.chat-search-wrapper input {
	padding-right: 2.5rem;
	border-radius: 8px;
	border: 1px solid #e9ecef;
}

.search-icon {
	position: absolute;
	right: 1.5rem;
	top: 50%;
	transform: translateY(-50%);
	color: #6c757d;
}

.chat-list .hover-effect {
	transition: all 0.3s ease;
}

.chat-list .hover-effect:hover {
	background: #f8f9fa;
	transform: translateX(5px);
}

.avatar-wrapper {
	position: relative;
	margin-left: 1rem;
}

.status-dot {
	position: absolute;
	bottom: 0;
	right: 0;
	width: 8px;
	height: 8px;
	border-radius: 50%;
	border: 2px solid #fff;
}

/* Notifications Styles */
.notifications-wrapper {
	background: #fff;
}

.notifications-header {
	background: #f8f9fa;
}

.notifications-header .btn-light {
	border-radius: 6px;
	padding: 0.25rem 0.75rem;
	font-size: 0.875rem;
}

.notification-item {
	padding: 1rem;
	border-bottom: 1px solid #f1f1f1;
	transition: all 0.3s ease;
}

.notification-item:hover {
	background: #f8f9fa;
}

.notification-item.unread {
	background: rgba(52, 152, 219, 0.05);
}

.notification-icon {
	width: 40px;
	height: 40px;
	border-radius: 10px;
	display: flex;
	align-items: center;
	justify-content: center;
	margin-left: 1rem;
	color: #fff;
}

.notification-content {
	flex: 1;
}

.notification-content h6 {
	font-size: 0.9rem;
	font-weight: 600;
	color: #2c3e50;
}

.notification-content p {
	font-size: 0.85rem;
	color: #6c757d;
}

.notifications-footer .btn-primary {
	border-radius: 8px;
	padding: 0.5rem 1rem;
	font-weight: 500;
	background: linear-gradient(45deg, #3498db, #2c3e50);
	border: none;
	transition: all 0.3s ease;
}

.notifications-footer .btn-primary:hover {
	transform: translateY(-2px);
	box-shadow: 0 4px 12px rgba(52, 152, 219, 0.2);
}

/* Badge Styles */
.badge {
	padding: 0.25rem 0.5rem;
	font-size: 0.75rem;
	font-weight: 500;
	border-radius: 6px;
}

/* Animations */
@keyframes slideIn {
	from {
		transform: translateX(100%);
		opacity: 0;
	}
	to {
		transform: translateX(0);
		opacity: 1;
	}
}

.notification-item {
	animation: slideIn 0.3s ease forwards;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
	.sidebar {
		width: 100%;
	}
}

/* Additional styles for empty state */
.empty-state-icon {
	width: 60px;
	height: 60px;
	background: #f8f9fa;
	border-radius: 50%;
	display: flex;
	align-items: center;
	justify-content: center;
	margin: 0 auto;
	font-size: 24px;
	color: #6c757d;
}

/* Style for mark read button */
.mark-read-form .btn-light {
	font-size: 0.8rem;
	padding: 0.2rem 0.5rem;
	border-radius: 4px;
	transition: all 0.3s ease;
}

.mark-read-form .btn-light:hover {
	background: #3498db;
	color: white;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
	// Handle mark as read forms
	document.querySelectorAll('.mark-read-form').forEach(form => {
		form.addEventListener('submit', function(e) {
			e.preventDefault();
			const formData = new FormData(this);
			
			fetch(this.action, {
				method: 'POST',
				body: formData,
				headers: {
					'X-Requested-With': 'XMLHttpRequest'
				}
			})
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					// Remove the notification item
					const notificationItem = this.closest('.notification-item');
					if (notificationItem) {
						notificationItem.style.opacity = '0';
						setTimeout(() => notificationItem.remove(), 300);
					}
					// Update unread count
					updateUnreadCount(data.unreadCount);
				}
			})
			.catch(error => {
				console.error('Error:', error);
			});
		});
	});

	// Handle mark all as read form
	const markAllForm = document.querySelector('.mark-all-form');
	if (markAllForm) {
		markAllForm.addEventListener('submit', function(e) {
			e.preventDefault();
			const formData = new FormData(this);
			
			fetch(this.action, {
				method: 'POST',
				body: formData,
				headers: {
					'X-Requested-With': 'XMLHttpRequest'
				}
			})
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					// Remove all unread notifications
					document.querySelectorAll('.notification-item.unread').forEach(item => {
						item.style.opacity = '0';
						setTimeout(() => item.remove(), 300);
					});
					// Update unread count
					updateUnreadCount(0);
				}
			})
			.catch(error => {
				console.error('Error:', error);
			});
		});
	}

	// Function to update unread count
	function updateUnreadCount(count) {
		const badge = document.querySelector('.badge-pill');
		if (badge) {
			if (count > 0) {
				badge.textContent = count;
			} else {
				badge.remove();
			}
		}
	}

	// Add hover effect to notification items
	document.querySelectorAll('.notification-item').forEach(item => {
		item.addEventListener('mouseenter', function() {
			this.style.transform = 'translateX(5px)';
		});
		
		item.addEventListener('mouseleave', function() {
			this.style.transform = 'translateX(0)';
		});
	});
});
</script>
