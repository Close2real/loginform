class ApiErrorResponse extends Error {

	code?: number;
	data?: any;

	constructor(message?: string, code?: number, data?: any) {
		super(message);
		Object.setPrototypeOf(this, ApiErrorResponse.prototype);
		this.name = "ApiErrorResponse";
		this.code = code;
		this.data = data;
	}
}

export default ApiErrorResponse;