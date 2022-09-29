export interface Pagination {
	page: number;
	pageElements: number;
	totalPage: number;
	totalElements: number;
}

export interface ApiResponse<T = never> {
	code: number;
	hasError: boolean;
	errorMessage?: string;
	locale?: string;
	data: T
}

export interface ApiResponsePaginated<T> extends ApiResponse {
	pagination: Pagination;
}

export interface PaginatedServiceResponse<T> {
	data: T;
	pagination: Pagination;
}
