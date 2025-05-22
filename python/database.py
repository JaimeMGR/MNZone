import mysql.connector
from mysql.connector import Error
import configparser
import tkinter.messagebox as messagebox
from datetime import datetime

class DatabaseManager:
    def __init__(self):
        self.config = configparser.ConfigParser()
        self.config.read('config.ini')
        
        self.host = self.config['database']['host']
        self.database = self.config['database']['database']
        self.user = self.config['database']['user']
        self.password = self.config['database'].get('password', '')
    
    def connect(self):
        try:
            connection = mysql.connector.connect(
                host=self.host,
                database=self.database,
                user=self.user,
                password=self.password if self.password else None,
                autocommit=True
            )
            if connection.is_connected():
                return connection
        except Error as e:
            error_msg = f"Error al conectar a MySQL: {e}"
            print(error_msg)
            messagebox.showerror("Error de Conexión", error_msg)
            return None
    
    def login_user(self, username, password):
        conn = None
        try:
            conn = self.connect()
            if conn is None:
                return None
                
            with conn.cursor(dictionary=True) as cursor:
                query = "SELECT id_socio, usuario, contrasena, tipo FROM socio WHERE usuario = %s"
                cursor.execute(query, (username,))
                user = cursor.fetchone()
                
                if user and self.check_password(password, user['contrasena']):
                    return user
                return None
        except Error as e:
            print(f"Error en login: {e}")
            return None
        finally:
            if conn and conn.is_connected():
                conn.close()
    
    def check_password(self, input_password, hashed_password):
        if input_password == hashed_password:
            return True
        
        try:
            import bcrypt
            if hashed_password.startswith('$2y$'):
                adjusted_hash = '$2b$' + hashed_password[4:]
                return bcrypt.checkpw(input_password.encode(), adjusted_hash.encode())
        except ImportError:
            pass
        
        import hashlib
        return hashlib.sha256(input_password.encode()).hexdigest() == hashed_password
    
    def get_user_times(self, user_id):
        conn = None
        try:
            conn = self.connect()
            if conn is None:
                return None
                
            with conn.cursor(dictionary=True) as cursor:
                query = """
                    SELECT categoria, tiempo_total 
                    FROM tiempos_sala 
                    WHERE id_socio = %s
                """
                cursor.execute(query, (user_id,))
                results = cursor.fetchall()
                
                times = {
                    'Sala_principal': 0,
                    'Sala_VIP': 0,
                    'Play_Station_5': 0,
                    'Simulador_coches': 0
                }
                
                for row in results:
                    if row['categoria'] in times:
                        times[row['categoria']] = row['tiempo_total'] / 60
                
                return times
        except Error as e:
            print(f"Error al obtener tiempos: {e}")
            return None
        finally:
            if conn and conn.is_connected():
                conn.close()
    
    def update_time(self, user_id, category, seconds_used):
        conn = None
        try:
            conn = self.connect()
            if conn is None:
                return False
                
            with conn.cursor() as cursor:
                query = """
                    UPDATE tiempos_sala 
                    SET tiempo_total = GREATEST(0, tiempo_total - %s)
                    WHERE id_socio = %s AND categoria = %s
                """
                cursor.execute(query, (seconds_used, user_id, category))
                return cursor.rowcount > 0
        except Error as e:
            print(f"Error al actualizar tiempo: {e}")
            return False
        finally:
            if conn and conn.is_connected():
                conn.close()
    
    def log_usage(self, user_id, category, start_time, end_time, seconds_used):
        conn = None
        try:
            conn = self.connect()
            if conn is None:
                return False
                
            with conn.cursor() as cursor:
                query = """
                    INSERT INTO registros_uso 
                    (id_socio, categoria, inicio, fin, segundos_utilizados)
                    VALUES (%s, %s, %s, %s, %s)
                """
                cursor.execute(query, (
                    user_id, 
                    category, 
                    start_time, 
                    end_time, 
                    seconds_used
                ))
                return True
        except Error as e:
            print(f"Error al registrar uso: {e}")
            return False
        finally:
            if conn and conn.is_connected():
                conn.close()