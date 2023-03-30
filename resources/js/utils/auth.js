
import {TOKEN}from '../component/constant/index.js'

export function getToken(){
	return localStorage.getItem(TOKEN)
}