//import { io } from "socket.io-client";

export const socket = connectionsocketserver();

function connectionsocketserver(){
    let socket
    try {
        socket = io(/* 'http://127.0.0.1:3000/', */ 'https://wsschat.padin.com.pe/', {
            transports: ['polling'],
            withCredentials: true,
            extraHeaders: {
                'Access-Control-Allow-Origin': '*',
            },
            reconnection: false,
            allowEIO3: true
        });
    } catch (error) {
        console.log('Socket no Connectado');
    }
  
    return socket;
}