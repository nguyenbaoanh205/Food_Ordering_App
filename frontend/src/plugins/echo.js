import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// Đặt Pusher trong window (Laravel Echo cần)
window.Pusher = Pusher;

const echo = new Echo({
  broadcaster: 'pusher',
  key: 'f5a067c1382391dc9449',
  cluster: 'ap1',
  // forceTLS: true, chạy local kh nên bật
  encrypted: true,
  forceTLS: false,
  enabledTransports: ['ws', 'wss'], // Cho phép cả ws và wss
  disableStats: true, // Tắt stats để tăng performance
});

// Log connection status sau khi echo được khởi tạo
// setTimeout(() => {
//   if (echo.connector && echo.connector.pusher && echo.connector.pusher.connection) {
//     const pusher = echo.connector.pusher;
    
//     pusher.connection.bind('connecting', () => {
//       console.log('🔄 Pusher đang kết nối...');
//     });
    
//     pusher.connection.bind('connected', () => {
//       console.log('✅ Pusher đã kết nối thành công');
//     });
    
//     pusher.connection.bind('disconnected', () => {
//       console.warn('⚠️ Pusher đã ngắt kết nối');
//     });
    
//     pusher.connection.bind('error', (error) => {
//       console.error('❌ Pusher error:', error);
//     });
    
//     pusher.connection.bind('state_change', (states) => {
//       console.log('🔄 Pusher state change:', states.previous, '->', states.current);
//     });
//   } else {
//     console.warn('⚠️ Pusher connector chưa sẵn sàng');
//   }
// }, 100);

export default echo;
