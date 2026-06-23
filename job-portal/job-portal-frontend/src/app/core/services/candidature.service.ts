import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class CandidatureService {

  private baseUrl = 'http://localhost:8080';

  constructor(private http: HttpClient) {}

  // RECRUTEURS
  getRecruteurs(): Observable<any[]> {
    return this.http.get<any[]>(
      `${this.baseUrl}/candidatures/recruteurs`
    );
  }

  // CREATE CANDIDATURE
  createCandidature(data: FormData): Observable<any> {
    return this.http.post(
      `${this.baseUrl}/candidatures/upload`,
      data
    );
  }

  // CANDIDAT
  getMyCandidatures(candidatId: number): Observable<any[]> {
    return this.http.get<any[]>(
      `${this.baseUrl}/candidatures/candidat/${candidatId}`
    );
  }

  // RECRUTEUR (IMPORTANT)
  getCandidaturesByRecruiter(recruiterId: number): Observable<any[]> {
    return this.http.get<any[]>(
      `${this.baseUrl}/candidatures/recruteur/${recruiterId}`
    );
  }

  // UPDATE STATUS
  updateStatus(id: number, status: string): Observable<any> {
    return this.http.put(
      `${this.baseUrl}/candidatures/${id}/status?status=${status}`,
      {}
    );
  }

  // GET RECRUITER FROM USER ID (IMPORTANT FIX)
  getRecruiterByUserId(userId: number): Observable<any> {
    return this.http.get<any>(
      `${this.baseUrl}/candidatures/recruiter/by-user/${userId}`
    );
  }

  // GET BY ID
  getById(id: number): Observable<any> {
    return this.http.get<any>(
      `${this.baseUrl}/candidatures/${id}`
    );
  }
}
