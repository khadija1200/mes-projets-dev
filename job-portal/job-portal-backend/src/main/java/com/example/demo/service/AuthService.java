package com.example.demo.service;

import com.example.demo.dto.LoginRequest;
import com.example.demo.dto.LoginResponse;
import com.example.demo.dto.RegisterRequest;
import com.example.demo.model.Recruiter;
import com.example.demo.model.User;
import com.example.demo.repository.RecruiterRepository;
import com.example.demo.repository.UserRepository;
import org.springframework.stereotype.Service;

@Service
public class AuthService {

    private final UserRepository userRepository;
    private final RecruiterRepository recruiterRepository;

    public AuthService(UserRepository userRepository,
            RecruiterRepository recruiterRepository) {
        this.userRepository = userRepository;
        this.recruiterRepository = recruiterRepository;
    }

    // REGISTER
    public User register(RegisterRequest request) {

        if (userRepository.existsByEmail(request.getEmail())) {
            throw new RuntimeException("Email already exists");
        }

        User user = new User();
        user.setEmail(request.getEmail());
        user.setPassword(request.getPassword());
        user.setRole(request.getRole());

        User savedUser = userRepository.save(user);

        if (request.getRole().name().equals("RECRUTEUR")) {
            Recruiter recruiter = new Recruiter();
            recruiter.setCompanyName(request.getCompanyName());
            recruiter.setAddress(request.getAddress());
            recruiter.setUser(savedUser);

            recruiterRepository.save(recruiter);
        }

        return savedUser;
    }

    // LOGIN
    public LoginResponse login(LoginRequest request) {

        User user = userRepository.findByEmail(request.getEmail())
                .orElseThrow(() -> new RuntimeException("User not found"));

        if (!user.getPassword().equals(request.getPassword())) {
            throw new RuntimeException("Invalid password");
        }

        return new LoginResponse(
                user.getId(),
                user.getEmail(),
                user.getRole());
    }
}