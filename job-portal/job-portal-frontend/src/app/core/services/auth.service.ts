import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  private baseUrl = 'http://localhost:8080/auth';

  private currentUser: any = null;

  constructor(private http: HttpClient) {}

  register(data: any): Observable<any> {
    return this.http.post(`${this.baseUrl}/register`, data);
  }

  login(data: any): Observable<any> {
    return this.http.post(`${this.baseUrl}/login`, data);
  }

  // ✅ IMPORTANT : login + stockage automatique
  setUser(user: any) {
    this.currentUser = user;
    localStorage.setItem('user', JSON.stringify(user));
  }

  getUser() {
    if (!this.currentUser) {
      this.currentUser = JSON.parse(localStorage.getItem('user') || 'null');
    }
    return this.currentUser;
  }

  isLoggedIn(): boolean {
    return this.getUser() !== null;
  }

  logout() {
    this.currentUser = null;
    localStorage.removeItem('user');
  }
}
