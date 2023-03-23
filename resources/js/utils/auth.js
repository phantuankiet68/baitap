const TOKEN = 'token'

export function getToken(){
	return localStorage.getItem(TOKEN)
}